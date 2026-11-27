<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Coelesti — Сообщество')</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/community.css">
</head>
<body>

<!-- Бургер-меню (выплывает слева) -->
<div class="side-overlay" id="sideOverlay"></div>
<nav class="side-menu" id="sideMenu">
    <a href="/" class="side-link">Вернуться на основной сайт</a>
    <a href="/community" class="side-link">Главная сообщества</a>
    <a href="/create-post" class="side-link">Создать пост</a>
    <a href="/subscription" class="side-link">Подписка</a>
    <hr class="side-divider">
    <a href="/privacy" class="side-link">Политика конфиденциальности</a>
    <a href="/terms" class="side-link">Пользовательское соглашение</a>
    <a href="/rules" class="side-link">Правила Coelesti</a>
    <p class="side-copy">Coelesti © 2026. Все права защищены.</p>
</nav>

<!-- Хедер сообщества -->
<header class="community-header">
    <div class="ch-left">
        <button class="burger" id="burgerBtn" aria-label="Меню">
            <span></span><span></span><span></span>
        </button>
        <a href="/" class="ch-logo">COELESTI</a>
    </div>

    <input type="text" class="ch-search" placeholder="Поиск по coelesti">

    <div class="ch-right">
        @guest
            <a href="/login" class="btn-login">Войти</a>
        @endguest
            @auth
                <a href="/profile" class="avatar-circle">
                    @if (auth()->user()->avatar)
                        <img src="/storage/avatars/{{ auth()->user()->avatar }}?v={{ time() }}" alt="Аватар">
                    @else
                        <svg viewBox="0 0 24 24" fill="white"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                    @endif
                </a>
            @endauth
    </div>
</header>

@yield('content')

<script>
    const burger = document.getElementById('burgerBtn');
    const menu = document.getElementById('sideMenu');
    const overlay = document.getElementById('sideOverlay');

    function openMenu() { menu.classList.add('open'); overlay.classList.add('show'); }
    function closeMenu() { menu.classList.remove('open'); overlay.classList.remove('show'); }

    burger.addEventListener('click', () => menu.classList.contains('open') ? closeMenu() : openMenu());
    overlay.addEventListener('click', closeMenu);
</script>

</body>
</html>
