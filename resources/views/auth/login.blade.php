@extends('layouts.auth')

@section('title', 'Вход — Coelesti')

@section('quote', 'Какие-нибудь умные крутые слова<br>лого хз что-нибудь такое')

@section('content')

    <h1 class="auth-form-title">Вход</h1>
    <div class="auth-divider"></div>

    @if ($errors->any())
        <div class="form-errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/login" class="auth-form">
        @csrf

        <label>Ник пользователя
            <input type="text" name="username" value="{{ old('username') }}" required>
        </label>

        <label>Пароль
            <input type="password" name="password" required>
        </label>

        <button type="submit" class="auth-submit-btn">Войти</button>

        <div class="auth-divider"></div>

        <button type="button" class="auth-google-btn">Войти через Google</button>

        <p class="auth-switch-link">
            Нет аккаунта? <a href="/register">Регистрация</a>
        </p>
    </form>

@endsection
