<?php

namespace App\Http\Controllers;

use App\Match;
use App\MatchFilters;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\ApiResponse;
use Illuminate\Support\Facades\Input;

class MatchesController extends Controller
{
    use ApiResponse;

    public function index(MatchFilters $filters)
    {
        $limit = Input::get('limit') ?: null;

        // Filter matches
        $matches = Match::filter($filters)->paginate($limit);

        // TODO: transform response
        return $this->respondWithPagination($matches);
    }

    public function show($id)
    {
        // TODO: transform response
        $match = Match::find($id);

        if (! $match) {
            return $this->respondNotFound('Match does not exist');
        }

        return $this->respond($match);
    }
}
