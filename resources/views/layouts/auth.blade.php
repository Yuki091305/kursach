<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Coelesli')</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/auth.css">
</head>
<body class="auth-body">

<div class="auth-page @yield('page-class')">

    <!-- Левая часть: текст + кнопка назад -->
    <div class="auth-left">
        <div class="auth-left-content">
            <p class="auth-quote">@yield('quote')</p>
            <a href="/" class="auth-back-btn">
                Вернуться на главную
                <span class="arrow">‹</span>
            </a>
        </div>
    </div>

    <!-- Правая часть: форма на полупрозрачном блоке -->
    <div class="auth-right">
        <div class="auth-form-wrapper">
            <a href="/" class="auth-logo">COELESLI</a>
            @yield('content')
        </div>
    </div>

</div>

</body>
</html>
