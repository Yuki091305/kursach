@extends('layouts.app')

@section('title', 'Coelesti — Все об ангелах')

@section('content')

    <section class="hero">
        <div class="hero-content">
            <p class="hero-logo">COELESLI</p>
            <p class="hero-subtitle">Все об ангелах для вашего удобства</p>
        </div>
    </section>

    <section class="welcome-block">
        <p>Добро пожаловать в мир ангелологии.<br>
            Изучайте. Обсуждайте. Создавайте</p>
    </section>

    <section class="choice-block">
        <p>Можно заняться любым делом, какое выберешь ты?</p>
    </section>

    <section class="cards-section">
        <div class="cards-container">

            <div class="card">
                <div class="card-image" style="background-image: url('/images/enciklopedia.png');">
                    <span class="card-title">Энциклопедия</span>
                </div>
                <a href="/encyclopedia" class="card-btn">Посмотреть</a>
            </div>

            <div class="descriptions">
                <div class="desc-block">
                    <p>Энциклопедия – это то, где вы можете ознакомиться с теорией и почитать интересующую вас информацию</p>
                </div>
                <div class="desc-block">
                    <p>Сообщество – это то, где вы можете общаться с другими людьми, создавать свою сферу для общения и находить друзей.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-image" style="background-image: url('/images/soobsh.png');">
                    <span class="card-title">Сообщество</span>
                </div>
                <a href="/login" class="card-btn">Войти</a>
            </div>

        </div>
    </section>

    <section class="subscribe-section">
        <div class="subscribe-content">
            <h2 class="subscribe-title">Стань хранителем Ангелологии</h2>
            <p class="subscribe-subtitle">Твой вклад поможет сайту жить, а тебе откроет больше возможностей!</p>
            <ul class="subscribe-list">
                <li>Смена обложки на своём аккаунте!</li>
                <li>Выбор особой рамки для аватара!</li>
                <li>Привилегии в постах!</li>
            </ul>
            <div class="subscribe-buttons">
                @guest
                    <a href="/login" class="btn btn-dark">Присоединиться</a>
                    <a href="/login" class="btn btn-light">Подробнее</a>
                @endguest
                @auth
                    <a href="/subscription" class="btn btn-dark">Оформить подписку</a>
                    <a href="/subscription" class="btn btn-light">Подробнее</a>
                @endauth
            </div>
        </div>
    </section>

@endsection
