<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();

        if ($user->likes()->where('post_id', $post->id)->exists()) {
            $user->likes()->detach($post->id);
            $liked = false;
        } else {
            $user->likes()->attach($post->id);
            $liked = true;
        }

        $post->update(['likes_count' => $post->likes()->count()]);

        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count(),
        ]);
    }
}
