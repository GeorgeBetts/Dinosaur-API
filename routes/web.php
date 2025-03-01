<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Dinosaur-Api' => app()->version()];
});
