<?php

namespace App\Http\Controllers;

use App\League;
use App\Http\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueRequest;
use App\Http\Requests\UpdateLeagueRequest;
use App\Transformers\LeagueTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Validator;

class LeaguesController extends Controller
{
    use ApiResponse;

    /**
     * @var \Transformers\LeagueTransformer
     */
    protected $leagueTransformer;

    public function __construct(LeagueTransformer $leagueTransformer)
    {
        $this->leagueTransformer = $leagueTransformer;
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $limit = Input::get('limit') ?: null;
        $leagues = League::paginate($limit);

        return $this->respondWithPagination($leagues,
            $this->leagueTransformer
                 ->transformCollection($leagues->all())
        );
    }

    /**
     * [show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
        $league = League::find($id);

        if (! $league) {
            return $this->respondNotFound('League does not exist');
        }

        return $this->respond(
            $this->leagueTransformer
                 ->transform($league)
        );
    }

    /**
     * [store description]
     * @param  StoreLeagueRequest $request [description]
     * @return [type]                        [description]
     */
    public function store(StoreLeagueRequest $request)
    {
        $league = League::create(Input::all());
        $url = URL::action('LeaguesController@show', [$league->id]);

        return $this->respondCreated('League successfully created.', $url);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(UpdateLeagueRequest $request, $id)
    {
        $league = League::find($id);

        if (! $league) {
            return $this->respondNotFound('League does not exist');
        }

        // Call fill on the document and pass in the data
        $league->fill(Input::all());

        $league->save();

        return $this->respondNoContent();
    }
}
