@extends('layouts.community')

@section('title', 'Подписка — Coelesti')

@section('content')

    <main class="subscription-page">
        <div class="subscription-card">
            <h1 class="subscription-title">Стань хранителем Ангелологии</h1>
            <p class="subscription-subtitle">Твой вклад поможет сайту жить, а тебе откроет больше возможностей!</p>

            <div class="subscription-features">
                <div class="feature">
                    <span class="feature-icon">🎨</span>
                    <div>
                        <strong>Смена обложки профиля</strong>
                        <p>Установи любую картинку как обложку своего профиля</p>
                    </div>
                </div>
                <div class="feature">
                    <span class="feature-icon">✨</span>
                    <div>
                        <strong>Особая рамка для аватара</strong>
                        <p>Выделяйся среди других пользователей</p>
                    </div>
                </div>
                <div class="feature">
                    <span class="feature-icon">👑</span>
                    <div>
                        <strong>Привилегии в постах</strong>
                        <p>Закрепляй посты и получай больше возможностей</p>
                    </div>
                </div>
            </div>

            <div class="subscription-price">
                <span class="price-amount">199 ₽</span>
                <span class="price-period">/ месяц</span>
            </div>

            @if (session('success'))
                <div class="subscription-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="subscription-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (auth()->user()->is_subscribed)
                <div class="already-subscribed">
                    <p>✅ У вас уже оформлена подписка</p>
                    <form method="POST" action="/subscription/cancel">
                        @csrf
                        <button type="submit" class="btn-cancel" onclick="return confirm('Точно отменить подписку? Обложка профиля будет удалена.')">
                            Отменить подписку
                        </button>
                    </form>
                </div>
            @else
                <form method="POST" action="/subscription" class="subscription-form">
                    @csrf

                    <div class="payment-simulation">
                        <h3>Симуляция оплаты</h3>
                        <p class="payment-note">Это демонстрационный режим. Реальная оплата не производится.</p>

                        <label class="payment-field">
                            Номер карты
                            <input type="text" placeholder="0000 0000 0000 0000" maxlength="19">
                        </label>

                        <div class="payment-row">
                            <label class="payment-field">
                                Срок
                                <input type="text" placeholder="MM/ГГ" maxlength="5">
                            </label>
                            <label class="payment-field">
                                CVV
                                <input type="password" placeholder="•••" maxlength="3">
                            </label>
                        </div>
                    </div>

                    <label class="agree-label">
                        <input type="checkbox" name="agree" value="1" required>
                        <span>Я принимаю условия подписки и даю согласие на списание 199 ₽/мес (симуляция)</span>
                    </label>

                    <button type="submit" class="btn-subscribe">Оформить подписку</button>
                </form>
            @endif
        </div>
    </main>

@endsection
