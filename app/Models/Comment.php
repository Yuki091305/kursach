<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
    ];

    // Комментарий принадлежит пользователю
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Комментарий принадлежит посту
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Родительский комментарий (если это ответ)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Дочерние комментарии (ответы)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Форматирование времени
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
