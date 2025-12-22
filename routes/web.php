<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return redirect()->route('cars.index');
});

Route::resource('cars', CarController::class)->names([
    'index' => 'cars.index',
    'create' => 'cars.create',
    'store' => 'cars.store',
    'show' => 'cars.show',
    'edit' => 'cars.edit',
    'update' => 'cars.update',
    'destroy' => 'cars.destroy',
]);

// Логин
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Регистрация
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Выход
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');