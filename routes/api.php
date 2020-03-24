<?php

use Illuminate\Support\Facades\Route;

Route::get('{country:slug}/stats/{level?}', 'StatsController@index');
