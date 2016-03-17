<?php

namespace App\Http\Controllers;

use App\Team;
use App\Http\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Transformers\TeamTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Validator;

class TeamsController extends Controller
{
    use ApiResponse;

    /**
     * @var \Transformers\TeamTransformer
     */
    protected $teamTransformer;

    public function __construct(TeamTransformer $teamTransformer)
    {
        $this->teamTransformer = $teamTransformer;
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $limit = Input::get('limit') ?: null;
        $teams = Team::paginate($limit);

        return $this->respondWithPagination($teams,
            $this->teamTransformer
                 ->transformCollection($teams->all())
        );
    }

    /**
     * [show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
        $team = Team::find($id);

        if (! $team) {
            return $this->respondNotFound('Team does not exist');
        }

        return $this->respond(
            $this->teamTransformer
                 ->transform($team)
        );
    }

    /**
     * [store description]
     * @param  StoreTeamRequest $request [description]
     * @return [type]                        [description]
     */
    public function store(StoreTeamRequest $request)
    {
        $team = Team::create(Input::all());
        $url = URL::action('TeamsController@show', [$team->id]);

        return $this->respondCreated('Team successfully created.', $url);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(UpdateTeamRequest $request, $id)
    {
        $team = Team::find($id);

        if (! $team) {
            return $this->respondNotFound('Team does not exist');
        }

        // Call fill on the document and pass in the data
        $team->fill(Input::all());

        $team->save();

        return $this->respondNoContent();
    }
}
