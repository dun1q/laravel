@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
<div class="container mt-4">
    <h2>Пользователи</h2>
    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div>
                    <strong>{{ $user->name }}</strong>
                    <span class="text-muted">({{ $user->email }})</span>
                    @auth
                        @if(auth()->id() !== $user->id)
                            @if(optional(auth()->user()->friends)->contains($user))
                                <span class="badge bg-success ms-2">В друзьях</span>
                            @endif
                        @endif
                    @endauth
                </div>
                <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary btn-sm">Профиль</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection