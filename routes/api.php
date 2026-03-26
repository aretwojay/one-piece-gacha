<?php

use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/characters', [CharacterController::class, 'index']);
Route::get('/characters/search', [CharacterController::class, 'search']);
Route::get('/characters/{id}', [CharacterController::class, 'show']);