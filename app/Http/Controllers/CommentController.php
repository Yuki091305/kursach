<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    // Добавить комментарий
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:1000',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        // Обновляем счётчик комментариев
        $post = Post::find($request->post_id);
        $post->comments_count = $post->comments()->count();
        $post->save();

        return back()->with('success', 'Комментарий добавлен');
    }

    // Удалить комментарий (только автор)
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Это не ваш комментарий');
        }

        $postId = $comment->post_id;
        $comment->delete();

        // Обновляем счётчик
        $post = Post::find($postId);
        if ($post) {
            $post->comments_count = $post->comments()->count();
            $post->save();
        }

        return back()->with('success', 'Комментарий удалён');
    }
}
