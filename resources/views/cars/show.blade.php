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
</div>
@endsection