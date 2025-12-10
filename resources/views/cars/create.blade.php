@extends('layouts.app')

@section('title', 'Добавить автообъявление')

@section('content')
<h2>Добавить автообъявление</h2>
<form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('cars._form')
    <button type="submit" class="btn btn-danger">Сохранить</button>
    <a href="{{ route('cars.index') }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection