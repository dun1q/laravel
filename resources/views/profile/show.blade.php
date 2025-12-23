@extends('layouts.app')

@section('title', 'Профиль пользователя: ' . $user->name)

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="mb-2">{{ $user->name }}</h3>
                    <div class="mb-3 text-secondary">
                        Email: {{ $user->email }}
                    </div>

                    {{-- Кнопка дружбы --}}
                    @auth
                        {{-- Не показываем себе самому --}}
                        @if(auth()->user()->id !== $user->id)
                            @if(auth()->user()->friends->contains($user))
                                <form action="{{ route('users.removeFriend', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Удалить из друзей</button>
                                </form>
                            @else
                                <form action="{{ route('users.addFriend', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Добавить в друзья</button>
                                </form>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Список друзей пользователя --}}
            <div class="card mb-4">
                <div class="card-header">
                    Друзья пользователя {{ $user->name }} ({{ $user->friends->count() }})
                </div>
                <div class="card-body">
                    @if($user->friends->count())
                        <ul class="list-group">
                            @foreach($user->friends as $friend)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $friend->name }}
                                    <a href="{{ route('users.show', $friend) }}" class="btn btn-link btn-sm">Профиль</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">Нет друзей.</div>
                    @endif
                </div>
            </div>

            {{-- Здесь можно добавить другие данные пользователя, например, его объявления --}}
            <div class="card">
                <div class="card-header">
                    Объявления пользователя {{ $user->name }}
                </div>
                <div class="card-body">
                    @if($user->cars->count())
                        <ul class="list-group">
                            @foreach($user->cars as $car)
                                <li class="list-group-item">
                                    <a href="{{ route('cars.show', $car) }}">{{ $car->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">Нет опубликованных объявлений.</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection