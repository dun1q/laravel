<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение email</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    Подтверждение email
                </div>
                <div class="card-body">

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            Ссылка для подтверждения отправлена на ваш email.
                        </div>
                    @endif

                    <p>Прежде чем продолжить, пожалуйста, проверьте свою почту и перейдите по ссылке для подтверждения.</p>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Отправить ссылку повторно</button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">Выйти</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
