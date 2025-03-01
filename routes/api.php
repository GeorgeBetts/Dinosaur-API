<?php

use App\Http\Controllers\DinosaurController;

Route::get('/dinosaurs', [DinosaurController::class, 'index']);
Route::get('/dinosaurs/{dinosaur}', [DinosaurController::class, 'show']);
