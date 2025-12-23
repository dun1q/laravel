@extends('layouts.app')

@section('title', 'Профиль: ' . $user->name)

@section('content')
<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-body">
            <h3>{{ $user->name }}</h3>
            <div class="text-muted mb-2">{{ $user->email }}</div>
            
            @auth
                @if(auth()->id() !== $user->id)
                    @if(auth()->user()->friends->contains($user))
                        <form action="{{ route('users.removeFriend', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Удалить из друзей</button>
                        </form>
                    @else
                        <form action="{{ route('users.addFriend', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Добавить в друзья</button>
                        </form>
                    @endif
                @endif
            @endauth
        </div>
    </div>

    {{-- Список его друзей --}}
    <div class="card mb-4">
        <div class="card-header">
            Друзья пользователя ({{ $user->friends->count() }})
        </div>
        <div class="card-body">
            @forelse($user->friends as $friend)
                <a href="{{ route('users.show', $friend) }}">{{ $friend->name }}</a>@if(!$loop->last), @endif
            @empty
                <div class="text-muted">Друзей нет.</div>
            @endforelse
        </div>
    </div>

    {{-- Можно вывести объявления пользователя, если хочешь --}}
    <div class="card">
        <div class="card-header">
            Объявления пользователя:
        </div>
        <div class="card-body">
            @if($user->cars->count())
                <ul>
                @foreach($user->cars as $car)
                    <li>
                        <a href="{{ route('cars.show', $car) }}">{{ $car->title }}</a>
                    </li>
                @endforeach
                </ul>
            @else
                <div class="text-muted">Нет объявлений.</div>
            @endif
        </div>
    </div>
</div>
@endsection