<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\GachaController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): RedirectResponse {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [GachaController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-characters', [CharacterController::class, 'inventory'])->name('user.characters');
    Route::post('/my-characters/{character}/claim', [CharacterController::class, 'claim'])->name('gacha.claim');
    Route::get('/characters', [CharacterController::class, 'catalog'])->name('characters.index');
    Route::get('/characters/{character}', [CharacterController::class, 'details'])->name('characters.show');
    Route::get('/tirage/animation', [GachaController::class, 'showPullAnimation'])->name('gacha.pull-animation');
    Route::get('/tirage/fetch-character', [GachaController::class, 'fetchCharacter'])
        ->middleware('throttle:gacha-pulls')
        ->name('gacha.fetch-character');
    Route::get('/tirage', [GachaController::class, 'pull'])->name('gacha.pull');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
