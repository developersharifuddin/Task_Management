<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Route::get('/', [AuthenticatedSessionController::class, 'create']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
