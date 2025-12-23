@extends('layouts.app')

@section('title', 'Лента друзей')

@section('content')
<div class="container mt-4">
    <h2>Лента друзей</h2>
    @forelse($cars as $car)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $car->title }}</h5>
                <p>Добавлено {{ $car->user->name }} ({{ $car->created_at->format('d.m.Y H:i') }})</p>
                <p>{{ $car->description }}</p>
            </div>
        </div>
    @empty
        <p>Нет объявлений от ваших друзей.</p>
    @endforelse
</div>
@endsection