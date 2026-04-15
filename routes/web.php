<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GachaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tirage', [GachaController::class, 'pull']);