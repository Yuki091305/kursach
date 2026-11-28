<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class PostController extends Controller
{
    // Страница создания поста
    public function create()
    {
        return view('create-post');
    }

    // Сохранить пост
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable|max:5000',
            'image' => 'nullable|image|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath ? basename($imagePath) : null,
        ]);

        return redirect('/profile')->with('success', 'Пост опубликован!');
    }

    // Лента сообщества
    public function community()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);

        return view('community', compact('posts'));

    }

    // Удалить пост (только автор)
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Это не ваш пост');
        }

        if ($post->image) {
            Storage::disk('public')->delete('posts/' . $post->image);
        }

        $post->delete();

        return redirect('/profile')->with('success', 'Пост удалён');
    }

}
