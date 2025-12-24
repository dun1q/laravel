<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

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

// Восстановить мягкое удаление (POST /cars/{id}/restore)
Route::post('/cars/{car}/restore', [CarController::class, 'restore'])
    ->name('cars.restore')
    ->middleware('auth');

// Удалить навсегда (DELETE /cars/{id}/force-delete)
Route::delete('/cars/{car}/force-delete', [CarController::class, 'forceDelete'])
    ->name('cars.forceDelete')
    ->middleware('auth');

// Логин
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Регистрация
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Выход
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Объявления (CRUD)
Route::resource('cars', CarController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
Route::resource('cars', CarController::class)->only(['create', 'store', 'edit', 'update', 'destroy'])->middleware('auth');

// Комментарии
Route::post('/cars/{car}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Руты для дружбы
Route::post('/users/{user}/add-friend', [UserController::class, 'addFriend'])->name('users.addFriend');
Route::post('/users/{user}/remove-friend', [UserController::class, 'removeFriend'])->name('users.removeFriend');

// Список пользователей и страница их профиля
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// Лента друзей
Route::get('/feed', [UserController::class, 'feed'])->name('users.feed');

// Профиль пользователя
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile')->middleware('auth');