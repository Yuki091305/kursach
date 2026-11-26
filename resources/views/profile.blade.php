@extends('layouts.app')

@section('title', 'Профиль — Coelesti')

@section('content')
    <main class="page-content history-page">
        <h1 class="section-title">Привет, {{ auth()->user()->name }}!</h1>
        <p>Твой ник: <strong>{{ auth()->user()->username }}</strong></p>
        <p>Email: {{ auth()->user()->email }}</p>
    </main>
@endsection
