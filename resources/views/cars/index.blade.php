@extends('layouts.app')

@section('title', 'Автообъявления')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Автообъявления</h1>
    <a href="{{ route('cars.create') }}" class="btn btn-success">➕ Добавить</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
    @forelse ($cars as $car)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                @if ($car->image_path)
                    <img src="{{ asset('storage/' . $car->image_path) }}"
                         class="card-img-top"
                         alt="{{ $car->title }}"
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                         style="height: 200px;">
                        <span class="text-muted">Нет изображения</span>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $car->title }}</h5>
                    <p class="card-text text-muted small">
                        {{ $car->year }} г. | {{ number_format($car->mileage_km, 0, '', ' ') }} км
                        @if($car->published_at)
                            <small class="text-muted">Опубл.: {{ $car->published_at->format('d.m.Y H:i') }}</small>
                        @endif
                    </p>
                    <p class="card-text">{{ Str::limit($car->description, 100) }}</p>
                    <div class="mt-auto">
                        <strong class="text-danger">{{ number_format($car->price, 0, '', ' ') }} ₽</strong>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-primary btn-sm">Подробнее</a>
                        <div>
                            <a href="{{ route('cars.edit', $car) }}" class="btn btn-outline-warning btn-sm">✏️</a>
                            <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Удалить объявление?')">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Нет автообъявлений</div>
        </div>
    @endforelse
</div>
@endsection