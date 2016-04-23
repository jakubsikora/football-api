<?php

Route::group(['prefix' => 'api/v1'], function() {
    Route::post('authenticate', 'AuthController@authenticate');
    Route::get('refresh', 'AuthController@refresh');

    Route::resource('seasons', 'SeasonsController');
    Route::resource('leagues', 'LeaguesController');
    Route::resource('teams', 'TeamsController');
    Route::resource('matches', 'MatchesController');

    // TODO: include auth
    Route::group(['middleware' => ['jwt.auth']], function() {
    });
});

