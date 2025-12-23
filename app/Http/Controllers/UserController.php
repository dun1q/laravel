<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Список всех пользователей
    public function index()
    {
        // Можно скрыть себя самого из списка, если нужно: ->where('id', '!=', auth()->id())
        $users = \App\Models\User::with('friends')->get();
        return view('users.index', compact('users'));
    }

    // Профиль пользователя
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Добавить в друзья (и обоюдная дружба)
    public function addFriend(User $user)
    {
        $currentUser = auth()->user();

        if (!$currentUser->friends->contains($user)) {
            $currentUser->friends()->attach($user->id);
        }
        // -- обоюдная дружба (по расширенному уровню)
        if (!$user->friends->contains($currentUser)) {
            $user->friends()->attach($currentUser->id);
        }

        return back();
    }

    // Удалить из друзей (и разрыв обоюдного дружества)
    public function removeFriend(User $user)
    {
        $currentUser = auth()->user();
        $currentUser->friends()->detach($user->id);
        $user->friends()->detach($currentUser->id); // разрыв обоюдной дружбы

        return back();
    }

    // Лента действий друзей
    public function feed()
    {
        $user = auth()->user();

        // Исправлено! Явно указываем users.id
        $friends = $user->friends()->pluck('users.id');

        // Получаем все машины друзей, свежие сверху
        $cars = \App\Models\Car::whereIn('user_id', $friends)
            ->with('user')
            ->latest()
            ->get();

        return view('users.feed', compact('cars'));
    }
}
