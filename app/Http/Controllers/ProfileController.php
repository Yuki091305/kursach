<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $postsCount = $user->posts()->count();
        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();

        return view('profile', compact('user', 'postsCount', 'followersCount', 'followingCount'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|alpha_num|min:3|max:30|unique:users,username,' . $user->id,
            'name' => 'required|max:255',
            'bio' => 'nullable|max:500',
            'avatar' => 'nullable|image|max:2048',
            'cover' => 'nullable|image|max:2048',
        ], [
            'username.unique' => 'Этот ник уже занят.',
        ]);

        // Обновляем текстовые поля
        $user->username = $request->username;
        $user->name = $request->name;
        $user->bio = $request->bio;

        // Загружаем аватар
        if ($request->hasFile('avatar')) {
            // Удаляем старый аватар
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = basename($avatarPath);
        }

        // Загружаем обложку (только если есть подписка)
        if ($request->hasFile('cover') && $user->is_subscribed) {
            if ($user->cover) {
                Storage::disk('public')->delete('covers/' . $user->cover);
            }
            $coverPath = $request->file('cover')->store('covers', 'public');
            $user->cover = basename($coverPath);
        }

        $user->save();

        return redirect('/profile')->with('success', 'Профиль обновлён!');
    }
}
