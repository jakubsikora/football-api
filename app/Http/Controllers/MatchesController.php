<?php

namespace App\Http\Controllers;

use App\Match;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\ApiResponse;
use Illuminate\Support\Facades\Input;

class MatchesController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $limit = Input::get('limit') ?: null;
        $leagueCode = Input::get('leagueCode') ?: null;

        // Return all matches
        $matches = Match::leagueCode($leagueCode)->paginate();

        // $leagues = Match::paginate($limit);

        // TODO: transform response
        return $this->respond($matches);
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
