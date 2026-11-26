@extends('layouts.auth')

@section('title', 'Регистрация — Coelesti')

@section('quote', 'Какие-нибудь умные крутые слова<br>лого хз что-нибудь такое')

@section('content')

    <h1 class="auth-form-title">Регистрация</h1>
    <div class="auth-divider"></div>

    @if ($errors->any())
        <div class="form-errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/register" class="auth-form">
        @csrf

        <div class="auth-form-row">
            <label>Имя пользователя
                <input type="text" name="name" value="{{ old('name') }}" required>
            </label>
            <label>Ник пользователя
                <input type="text" name="username" value="{{ old('username') }}" required>
            </label>
        </div>

        <label>E-mail пользователя
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>

        <label>Пароль
            <input type="password" name="password" required>
        </label>

        <label>Подтверждение пароля
            <input type="password" name="password_confirmation" required>
        </label>

        <button type="submit" class="auth-submit-btn">Создать аккаунт</button>

        <div class="auth-divider"></div>

        <button type="button" class="auth-google-btn">Продолжить через Google</button>

        <p class="auth-switch-link">
            Уже есть аккаунт? <a href="/login">Войти</a>
        </p>
    </form>

@endsection
