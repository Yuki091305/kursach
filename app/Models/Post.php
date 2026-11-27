<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'likes_count',
        'comments_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Форматирование времени ("1ч назад", "2д назад")
    public function getCreatedAtHumanAttribute()
    {
        $diff = now()->diff($this->created_at);

        if ($diff->y > 0) return $diff->y . 'г';
        if ($diff->m > 0) return $diff->m . 'м';
        if ($diff->d > 0) return $diff->d . 'д';
        if ($diff->h > 0) return $diff->h . 'ч';
        if ($diff->i > 0) return $diff->i . 'м';
        return 'только что';
    }
}
