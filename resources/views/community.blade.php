@extends('layouts.community')

@section('title', 'Сообщество — Coelesti')

@section('content')

    <main class="community-page">
        <!-- Вкладки -->
        <div class="community-tabs">
            <a href="/community" class="tab active">Для вас</a>
            <a href="/community?tab=following" class="tab">Подписки</a>
        </div>

        <!-- Лента постов -->
        <div class="posts-feed">
            @forelse ($posts as $post)
                <article class="post-card">
                    <!-- Шапка поста -->
                    <div class="post-header">
                        <div class="post-avatar">
                            @if ($post->user->avatar)
                                <img src="/storage/avatars/{{ $post->user->avatar }}?v={{ $post->user->updated_at->timestamp }}" alt="Аватар">
                            @else
                                <div class="avatar-placeholder"></div>
                            @endif
                        </div>
                        <div class="post-meta">
                            <a href="/profile/{{ $post->user->username }}" class="post-author">{{ $post->user->username }}</a>
                            <span class="post-time">• {{ $post->created_at_human }} назад</span>
                        </div>
                    </div>

                    <!-- Контент поста -->
                    @if ($post->content)
                        <p class="post-content">{{ $post->content }}</p>
                    @endif

                    @if ($post->image)
                        <img src="/storage/posts/{{ $post->image }}" alt="Изображение поста" class="post-image">
                    @endif

                    <!-- Иконки действий -->
                    <div class="post-actions">
                        <button class="action-btn like-btn" title="Лайк">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            <span>{{ $post->likes_count }}</span>
                        </button>
                        <button class="action-btn comment-btn" onclick="toggleCommentForm({{ $post->id }})" title="Комментарий">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                            <span>{{ $post->comments_count }}</span>
                        </button>
                    </div>

                    <!-- Форма добавления комментария -->
                    <div class="comment-form" id="commentForm-{{ $post->id }}" style="display:none;">
                        <form method="POST" action="/comment">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <textarea name="content" placeholder="Напишите комментарий..." required></textarea>
                            <button type="submit" class="btn-submit-comment">Отправить</button>
                        </form>
                    </div>

                    <!-- Комментарии -->
                    <div class="comments-section">
                        @foreach ($post->comments()->whereNull('parent_id')->with('user', 'replies.user')->get() as $comment)
                            <div class="comment">
                                <div class="comment-header">
                                    <img src="/storage/avatars/{{ $comment->user->avatar ?? 'default.png' }}" alt="Аватар" class="comment-avatar">
                                    <span class="comment-author">{{ $comment->user->username }}</span>
                                    <span class="comment-time">{{ $comment->created_at_human }} назад</span>
                                </div>
                                <p class="comment-content">{{ $comment->content }}</p>
                                <button class="btn-reply" onclick="showReplyForm({{ $comment->id }})">Ответить</button>

                                <!-- Форма ответа -->
                                <div class="reply-form" id="replyForm-{{ $comment->id }}" style="display:none;">
                                    <form method="POST" action="/comment">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <textarea name="content" placeholder="Ваш ответ..." required></textarea>
                                        <button type="submit" class="btn-submit-comment">Ответить</button>
                                    </form>
                                </div>

                                <!-- Ответы на комментарий -->
                                @foreach ($comment->replies as $reply)
                                    <div class="reply">
                                        <div class="comment-header">
                                            <img src="/storage/avatars/{{ $reply->user->avatar ?? 'default.png' }}" alt="Аватар" class="comment-avatar">
                                            <span class="comment-author">{{ $reply->user->username }}</span>
                                            <span class="comment-time">{{ $reply->created_at_human }} назад</span>
                                        </div>
                                        <p class="comment-content">{{ $reply->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </article>
            @empty
                <div class="no-posts">
                    <p>Пока нет постов. Будьте первым!</p>
                </div>
            @endforelse
        </div>

        {{ $posts->links() }}
    </main>
    <script>
        function toggleCommentForm(postId) {
            const form = document.getElementById('commentForm-' + postId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function showReplyForm(commentId) {
            const form = document.getElementById('replyForm-' + commentId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
@endsection
