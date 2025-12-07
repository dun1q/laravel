<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

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