<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/map', [MapController::class, 'index'])->name('home');
Route::get('/active', [MapController::class, 'active'])->name('active.tracks');
Route::get('/tracks/{track}', [MapController::class, 'show'])->name('tracks.show');
Route::post('/tracks/{track}/riders', [MapController::class, 'storeRider'])->name('riders.store');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);

    Route::get('/tracks/{track}/edit', [MapController::class, 'editTrack'])->name('tracks.edit');
    Route::put('/tracks/{track}', [MapController::class, 'updateTrack'])->name('tracks.update');
    Route::post('/tracks/{track}/images', [MapController::class, 'storeImages'])->name('tracks.images.store');
    Route::delete('/images/{image}', [MapController::class, 'destroyImage'])->name('images.destroy');
});
