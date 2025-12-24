<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;

// Группа роутов, защищённых аутентификацией по passport
Route::middleware('auth:api')->group(function () {
    Route::apiResource('cars', CarController::class);
    Route::apiResource('comments', \App\Http\Controllers\Api\CommentController::class);
});