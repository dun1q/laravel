@extends('layouts.app')

@section('title', 'Объявления')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-danger">Объявления</h1>
</div>

@if(auth()->user()?->is_admin)
    <div class="mb-3">
        @if(request('trashed'))
            <a href="{{ route('cars.index') }}" class="btn btn-sm btn-outline-secondary">← Все объявления</a>
        @else
            <a href="{{ route('cars.index', ['trashed' => 1]) }}" class="btn btn-sm btn-outline-warning">Показать удалённые</a>
        @endif
    </div>
@endif

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
                            <br><small>Опубл.: {{ $car->published_at->format('d.m.Y H:i') }}</small>
                        @endif
                    </p>
                    <p class="card-text">{{ Str::limit($car->description, 100) }}</p>
                    <div class="mt-auto">
                        <strong class="text-danger">{{ number_format($car->price, 0, '', ' ') }} ₽</strong>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cars.show', $car) }}" class="btn btn-danger btn-sm">Подробнее</a>
                        <small class="text-muted d-block mt-1">
                            Опубликовал: {{ $car->user->name ?? 'Аноним' }}
                        </small>
                        <div class="d-flex gap-2">
                            {{-- Редактировать — только владельцу --}}
                            @can('update-car', $car)
                                <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                            @endcan

                            {{-- Удалить — только владельцу --}}
                            @can('delete-car', $car)
                                <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить объявление?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                                </form>
                            @endcan

                            {{-- Восстановить / Удалить навсегда — только админу и только для удалённых --}}
                            @if(auth()->user()?->is_admin && $car->trashed())
                                <form action="{{ route('cars.restore', $car) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">↺</button>
                                </form>

                                <form action="{{ route('cars.forceDelete', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить навсегда? Это нельзя отменить.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-dark">❌</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Нет объявлений</div>
        </div>
    @endforelse
</div>
@endsection