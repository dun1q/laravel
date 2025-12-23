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

                <!--ФУТЕР НАЧАЛО-->
                <div class="card-footer bg-white">
    <div class="d-flex justify-content-between align-items-center" style="min-width:0;">
        <div class="d-flex align-items-center flex-grow-1 min-width-0" style="min-width:0;">
            <a href="{{ route('cars.show', $car) }}" class="btn btn-danger btn-sm me-2 flex-shrink-0">Подробнее</a>
            <small class="text-muted text-truncate d-block"
                   style="max-width:140px;"
                   title="Опубликовал: {{ $car->user->name ?? 'Аноним' }}">
                Опубликовал: {{ $car->user->name ?? 'Аноним' }}
            </small>
        </div>
        <div class="d-flex gap-2 flex-shrink-0">
            @if(!$car->trashed())
                @can('update-car', $car)
                    <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-outline-primary" title="Редактировать">
                        <i class="bi bi-pencil"></i>
                    </a>
                @endcan

                @can('delete-car', $car)
                    <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить объявление?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Удалить">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                @endcan
            @endif

            @if(auth()->user()?->is_admin && $car->trashed())
                <form action="{{ route('cars.restore', $car) }}" method="POST" class="d-inline" title="Восстановить">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </form>
                <form action="{{ route('cars.forceDelete', $car) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Удалить навсегда? Это нельзя отменить.')" title="Удалить навсегда">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-dark">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
                <!--ФУТЕР КОНЕЦ-->
                
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Нет объявлений</div>
        </div>
    @endforelse
</div>
@endsection