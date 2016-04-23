<?php

namespace App\Console\Commands;

use App\League;
use App\Match;
use App\Season;
use App\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use League\Csv\Reader;
use Symfony\Component\Console\Input\InputArgument;

class FetchMatchesCommand extends Command
{
    const COL_DATE = 1;
    const COL_HOME_TEAM = 2;
    const COL_AWAY_TEAM = 3;
    const COL_HOME_GOALS = 4;
    const COL_AWAY_GOALS = 5;
    const COL_WINNER = 6;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch-matches
                            {start_year_season : Desired start year of the season}
                            {end_year_season : Desired end year of the season}
                            {league_code : Desired league code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch matches from remote';

    private $baseUrl = 'http://www.football-data.co.uk/mmz4281/';

    private $season;
    private $league;

    private $processedMatches = [];

    private $fixTeamsMap = array(
        'Middlesboro' => 'Middlesbrough'
    );

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $startYearSeason = $this->argument('start_year_season');
        $endYearSeason = $this->argument('end_year_season');
        $leagueCode = $this->argument('league_code');

        // Get remote source url based on given arguments
        $url = $this->formatUrl($startYearSeason, $endYearSeason, $leagueCode);

        // Check if league exists
        $this->league = $this->processLeague($leagueCode);

        if ($this->league) {
            // Fetch all matches from the remote
            $matches = $this->fetchMatches($url);

            if (count($matches)) {
                $this->season = $this->processSeason($startYearSeason, $endYearSeason);

                // Process matches
                $this->processMatches($matches);
            }

            // Send notification to admin
            // $this->sendNotification();
        }
    }

    private function formatUrl($startYearSeason, $endYearSeason, $league)
    {
        return $this->baseUrl
            . substr($startYearSeason, 2)
            . substr($endYearSeason, 2)
            . '/'
            . $league
            . '.CSV';
    }

    private function fetchMatches($url)
    {
        $contents = file_get_contents($url);
        $reader = Reader::createFromString($contents);

        // Skip the header and fetch the rest
        return $reader->setOffset(1)->fetchAll(function ($row) {
            return $this->parseRow($row);
        });
    }

    private function parseRow($row)
    {
        return array(
            'date' => $row[self::COL_DATE],
            'home_team' => $row[self::COL_HOME_TEAM],
            'away_team' => $row[self::COL_AWAY_TEAM],
            'home_goals' => $row[self::COL_HOME_GOALS],
            'away_goals' => $row[self::COL_AWAY_GOALS],
            'winner' => $row[self::COL_WINNER],
        );
    }

    private function processSeason($startYearSeason, $endYearSeason)
    {
        $season = Season::firstOrNew([
            ['start_year', $startYearSeason],
            ['end_year', $endYearSeason],
        ]);

        if ( ! $season->id) {
            // Create new season
            $season->name = "Season {$startYearSeason}/{$endYearSeason}";
            $season->start_year = $startYearSeason;
            $season->end_year = $endYearSeason;
            $season->save();
        }

        return $season;
    }

    private function processLeague($leagueCode)
    {
        return League::where('code', $leagueCode)->first();
    }

    private function processTeam($teamName)
    {
        $team = Team::firstOrNew(['name' => $teamName]);

        if ( ! $team->id) {
            // Create new team
            $team->save();
        }

        return $team;
    }

    private function processMatches(array $matches)
    {
        foreach($matches as $match) {
            if (strlen($match['home_team']) > 0
                && strlen($match['away_team']) > 0) {

                if (array_key_exists($match['home_team'], $this->fixTeamsMap)) {
                    $homeName = $this->fixTeamsMap[$match['home_team']];
                } else {
                    $homeName = $match['home_team'];
                }

                if (array_key_exists($match['away_team'], $this->fixTeamsMap)) {
                    $awayName = $this->fixTeamsMap[$match['away_team']];
                } else {
                    $awayName = $match['away_team'];
                }

                $homeTeam = $this->processTeam($homeName);
                $awayTeam = $this->processTeam($awayName);
                $this->processMatch($match, $homeTeam, $awayTeam);
            }
        }
    }

    private function processMatch($matchData, $homeTeam, $awayTeam)
    {
        $match = Match::firstOrNew([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'season_id' => $this->season->id,
            'league_id' => $this->league->id,
        ]);

        if (! $match->id) {
            $match->home_team_id = $homeTeam->id;
            $match->away_team_id = $awayTeam->id;
            $match->season_id = $this->season->id;
            $match->league_id = $this->league->id;
            $match->home_goals = $matchData['home_goals'];
            $match->away_goals = $matchData['away_goals'];
            $match->winner = $matchData['winner'];

            $match->save();
            $this->processedMatches[] = $match;
        }
    }

    private function parseMatch($match)
    {

        dd("{$match->homeTeam->name}");

    }

    private function sendNotification()
    {
        $numberOfMatches = count($this->processedMatches);

        $subject = "Processed {$numberOfMatches} matches for: {$this->league->name} ({$this->league->country}) ({$this->season->name})";

        $body = "
        <ul>
        ";

        foreach($this->processedMatches as $match) {
            $body .= "
            <li>
                {$match->homeTeam->name} - {$match->awayTeam->name} {$match->home_goals} : {$match->away_goals}
            </li>";
        }

        $body .= "
        </ul>";

        // dd($body);
        Mail::send(['html' => 'emails.fetchSummary'], ['body' => $body], function($message) use ($subject)
        {
            $message->to('jakub.sikora.en@gmail.com');
            $message->subject($subject);
        });
    }
}
