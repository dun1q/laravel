@extends('layouts.app')

@section('title', 'Редактировать: ' . $car->title)

@section('content')
<h2>Редактировать: {{ $car->title }}</h2>
<form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('cars._form', ['car' => $car])
    <button type="submit" class="btn btn-danger">Обновить</button>
    <a href="{{ route('cars.index') }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection