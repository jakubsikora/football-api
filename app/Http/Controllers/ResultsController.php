<?php

namespace App\Http\Controllers;

use App\Result;
use App\Http\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Transformers\ResultTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Validator;

class ResultsController extends Controller
{
    use ApiResponse;

    /**
     * @var \Transformers\ResultTransformer
     */
    protected $resultTransformer;

    public function __construct(ResultTransformer $resultTransformer)
    {
        $this->resultTransformer = $resultTransformer;
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $limit = Input::get('limit') ?: null;
        $results = Result::paginate($limit);

        return $this->respondWithPagination($results,
            $this->resultTransformer
                 ->transformCollection($results->all())
        );
    }

    /**
     * [show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
        $result = Result::find($id);

        if (! $result) {
            return $this->respondNotFound('Result does not exist');
        }

        return $this->respond(
            $this->resultTransformer
                 ->transform($result)
        );
    }

    /**
     * [store description]
     * @param  StoreResultRequest $request [description]
     * @return [type]                        [description]
     */
    public function store(StoreResultRequest $request)
    {
        $result = Result::create(Input::all());
        $url = URL::action('ResultsController@show', [$result->id]);

        return $this->respondCreated('Result successfully created.', $url);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(UpdateResultRequest $request, $id)
    {
        $result = Result::find($id);

        if (! $result) {
            return $this->respondNotFound('Result does not exist');
        }

        // Call fill on the document and pass in the data
        $result->fill(Input::all());

        $result->save();

        return $this->respondNoContent();
    }
}
