<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Показать форму регистрации
    public function showRegister()
    {
        return view('auth.register');
    }

    // Обработать регистрацию
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|alpha_num|min:3|max:30|unique:users,username',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ], [
            'username.unique' => 'Этот ник уже занят. Придумайте другой.',
            'email.unique' => 'Этот email уже зарегистрирован.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/profile');
    }

    // Показать форму входа
    public function showLogin()
    {
        return view('auth.login');
    }

    // Обработать вход — по нику
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect('/profile');
        }

        return back()->withErrors(['username' => 'Неверный ник или пароль']);
    }

    // Выход
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
