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
        <a href="{{ route('cars.index') }}" class="btn btn-secondary mb-4">← Назад</a>

        {{-- Блок комментариев --}}
        <div class="card mt-4 mb-3">
            <div class="card-header">
                <strong>Комментарии</strong>
            </div>
            <div class="card-body p-3" style="max-height:300px; overflow-y:auto;">
                @forelse($car->comments as $comment)
                @php
                    $isFriend = auth()->check() && auth()->user()->friends && auth()->user()->friends->contains($comment->user);
                @endphp
                <div class="mb-2 border-bottom pb-2 p-2 rounded"
                    @if($isFriend) style="background:#e7ffe7;" @endif>
                    <span class="fw-semibold">
                        {{ $comment->user->name ?? 'Гость' }}
                        @if($isFriend)
                            <span class="badge bg-success ms-2">Друг</span>
                        @endif
                    </span>
                    <span class="text-muted small">({{ $comment->created_at->format('d.m.Y H:i') }})</span>
                    <div>{{ $comment->text }}</div>
                    @can('delete-comment', $comment)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline-block mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 m-0 text-danger" onclick="return confirm('Удалить комментарий?')">Удалить</button>
                        </form>
                    @endcan
                </div>
            @empty
                <div class="text-secondary">Комментариев пока нет.</div>
            @endforelse
            </div>
            @auth
                <div class="card-footer">
                    <form action="{{ route('comments.store', $car) }}" method="POST">
                        @csrf
                        <textarea name="text" rows="2" class="form-control mb-2" required placeholder="Ваш комментарий"></textarea>
                        <button type="submit" class="btn btn-primary btn-sm">Добавить комментарий</button>
                    </form>
                </div>
            @endauth
        </div>
        {{-- Конец блока комментариев --}}
    </div>

    <div class="mt-4">
        @if(!$car->trashed())
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
        @endif

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