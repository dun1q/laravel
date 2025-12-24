@extends('layouts.app')

@section('content')
<h1>Профиль</h1>

<p>
    <strong>Имя:</strong> {{ $user->name }}<br>
    <strong>Email:</strong> {{ $user->email }}
</p>

<h3>Ваш OAuth2 токен для API:</h3>
<pre style="word-break: break-all; background: #f4f4f4; padding:10px">{{ $token }}</pre>
<div><small>Скопируйте этот токен и используйте его для тестирования REST API в Postman.</small></div>
@endsection