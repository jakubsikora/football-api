<?php

namespace App\Http\Controllers;

use App\Season;
use App\Http\ApiResponse;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SeasonsController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $limit = Input::get('limit') ?: null;
        $seasons = Season::paginate($limit);

        return $this->respondWithPagination($seasons, $seasons->toArray()['data']);
    }
}
