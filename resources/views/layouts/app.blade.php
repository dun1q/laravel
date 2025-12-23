<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Доска автообьявлений')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- 🚩 ШАПКА -->
<header class="bg-white border-bottom py-3">

    <!-- Иконки на карточках -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <div class="container d-flex justify-content-between align-items-center">
        <!-- Логотип -->
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="auto.ru" width="46" height="40" class="me-2">
            <span class="text-danger fw-bold">Доска автообьявлений</span>
        </div>

        <!-- Правая часть: кнопки -->
        <div class="d-flex gap-2">
        @guest
            <a href="{{ url('/') }}" class="btn btn-outline-primary btn-sm">Главная</a>
            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Войти</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Регистрация</a>
            <a href="#" class="btn btn-danger px-4 disabled" title="Только для авторизованных">Загрузить</a>
        @else
            <a href="{{ url('/') }}" class="btn btn-outline-primary btn-sm">Главная</a>
            <a href="{{ route('cars.create') }}" class="btn btn-danger px-4">Загрузить</a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-sm">Пользователи</a>
            <a href="{{ route('users.feed') }}" class="btn btn-outline-primary btn-sm">Лента друзей</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                <button type="submit" class="btn btn-outline-secondary btn-sm">Выход</button>
            </form>
        @endguest
        </div>
    </div>
</header>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<div class="container mt-4 flex-grow-1">
    @yield('content')
</div>

<!-- 🚩 ФУТЕР -->
<footer class="bg-white border-top footer-fixed" style="height: 60px; display: flex; align-items: center; padding: 0 15px;">
    <div class="container d-flex justify-content-between align-items-center">
        <small class="text-muted">Ануфриев Данил</small>
        <div class="d-flex gap-2">
            <a href="https://t.me/dan_1ka" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle">
                Tg
            </a>
            <a href="https://github.com/dun1q" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle">
                Git
            </a>
        </div>
    </div>
</footer>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>