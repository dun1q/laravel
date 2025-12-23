@extends('layouts.app')

@section('title', $car->title)

@section('content')
<div class="row">
    <div class="col-md-6">
        @if ($car->image_path)
            <img src="{{ asset('storage/' . $car->image_path) }}"
                 class="img-fluid rounded shadow"
                 alt="{{ $car->title }}">
        @else
            <div class="bg-light d-flex align-items-center justify-content-center"
                 style="height: 400px; font-size: 1.2rem;">
                Изображение отсутствует
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <h2>{{ $car->title }}</h2>
        <p class="text-muted">
            <small>Опубликовал: {{ $car->user->name ?? 'Аноним' }}</small>
        </p>
        <table class="table table-borderless">
            <tr>
                <td><strong>Год:</strong></td>
                <td>{{ $car->year }}</td>
            </tr>
            <tr>
                <td><strong>Пробег:</strong></td>
                <td>{{ number_format($car->mileage_km, 0, '', ' ') }} км</td>
            </tr>
            <tr>
                <td><strong>Цена:</strong></td>
                <td><span class="text-danger h4">{{ number_format($car->price, 0, '', ' ') }} ₽</span></td>
            </tr>
            <tr>
                <td><strong>Описание:</strong></td>
                <td>{!! nl2br(e($car->description)) !!}</td>
            </tr>
            <tr>
                <td><strong>Опубликовано:</strong></td>
                <td>
                    {{ $car->published_at?->format('d.m.Y H:i:s') ?? 'Сейчас' }}
                </td>
            </tr>
        </table>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary">← Назад</a>
    </div>
    <div class="mt-4">

        @can('update-car', $car)
            <a href="{{ route('cars.edit', $car) }}" class="btn btn-primary">✏️</a>
        @endcan

        @can('delete-car', $car)
            <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">🗑️</button>
            </form>
        @endcan

        @if(auth()->user()?->is_admin && $car->trashed())
            <form action="{{ route('cars.restore', $car) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">↺</button>
            </form>

            <form action="{{ route('cars.forceDelete', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Навсегда?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-dark">❌</button>
            </form>
        @endif
    </div>
</div>
@endsection