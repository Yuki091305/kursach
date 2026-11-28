@extends('layouts.community')

@section('title', 'Профиль — Coelesti')

@section('content')

    <main class="profile-page">
        <!-- Обложка -->
        @if ($user->cover && $user->is_subscribed)
            <div class="profile-cover" style="background-image: url('/storage/covers/{{ $user->cover }}');"></div>
        @else
            <div class="profile-cover default-cover"></div>
        @endif

        <!-- Аватар и информация -->
        <div class="profile-info">
            <div class="profile-avatar">
                @if ($user->avatar)
                    <img src="/storage/avatars/{{ $user->avatar }}" alt="Аватар">
                @else
                    <svg viewBox="0 0 24 24" fill="white"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                @endif
            </div>

            <div class="profile-details">
                <h1 class="profile-name">{{ $user->name }}</h1>
                <p class="profile-username">{{ '@' . $user->username }}</p>

                <div class="profile-stats">
                    <span><strong>{{ $followersCount }}</strong> подписчиков</span>
                    <span>•</span>
                    <span><strong>{{ $followingCount }}</strong> подписок</span>
                    <span>•</span>
                    <span><strong>{{ $postsCount }}</strong> постов</span>
                </div>

                <div class="profile-actions">
                    <button class="btn-edit" onclick="openEditOverlay()">Редактировать профиль</button>
                    @if ($user->is_subscribed)
                        <span class="sub-badge">⭐ Подписка активна</span>
                    @else
                        <a href="/subscription" class="btn-subscribe-profile">Оформить подписку</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Описание -->
        <div class="profile-bio">
            @if ($user->bio)
                <p>{{ $user->bio }}</p>
            @else
                <p class="bio-placeholder">Пространство для описания</p>
            @endif
        </div>

        <!-- Иконки действий -->
        <div class="profile-icons">
            <a href="/create-post" class="icon-btn" title="Добавить пост">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
            </a>
            <button class="icon-btn" title="Лайки">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </button>
            <button class="icon-btn" title="Комментарии">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
            </button>
        </div>

        <!-- ВАШИ ПОСТЫ -->
        <h2 class="section-title">Ваши посты</h2>
        <div class="posts-container">
            @forelse ($user->posts()->latest()->get() as $post)
                <article class="post-card profile-post">
                    <div class="post-header">
                        <div class="post-avatar">
                            @if ($user->avatar)
                                <img src="/storage/avatars/{{ $user->avatar }}?v={{ $user->updated_at->timestamp }}" alt="Аватар">
                            @else
                                <div class="avatar-placeholder"></div>
                            @endif
                        </div>
                        <div class="post-meta">
                            <span class="post-author">{{ $user->username }}</span>
                            <span class="post-time">• {{ $post->created_at_human }} назад</span>
                        </div>
                        <form method="POST" action="/post/{{ $post->id }}" style="margin-left:auto;" onsubmit="return confirm('Удалить пост?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-post" title="Удалить пост">✕</button>
                        </form>
                    </div>

                    @if ($post->content)
                        <p class="post-content">{{ $post->content }}</p>
                    @endif

                    @if ($post->image)
                        <img src="/storage/posts/{{ $post->image }}" alt="Изображение" class="post-image">
                    @endif

                    <div class="post-actions">
                        <button class="action-btn like-btn {{ $post->likes->contains(auth()->id()) ? 'liked' : '' }}"
                                data-post="{{ $post->id }}">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            <span class="like-count">{{ $post->likes_count }}</span>
                        </button>
                        <button class="action-btn" title="Комментарий">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                            <span>{{ $post->comments_count }}</span>
                        </button>
                    </div>
                </article>
            @empty
                <p class="no-posts">У вас пока нет постов</p>
            @endforelse
        </div>

        <!-- ===== ВАШИ КОММЕНТАРИИ (НОВОЕ) ===== -->
        <h2 class="section-title">Ваши комментарии</h2>
        <div class="comments-container">
            @forelse ($user->comments()->with('post')->latest()->get() as $comment)
                <div class="profile-comment">
                    <div class="comment-header">
                        <span class="comment-author">{{ $comment->user->username }}</span>
                        <span class="comment-time">• {{ $comment->created_at_human }} назад</span>
                        <form method="POST" action="/comment/{{ $comment->id }}" style="margin-left:auto;" onsubmit="return confirm('Удалить комментарий?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-comment" title="Удалить комментарий">✕</button>
                        </form>
                    </div>
                    <p class="comment-content">{{ $comment->content }}</p>
                    <a href="/community" class="comment-post-link">К посту →</a>
                </div>
            @empty
                <p class="no-comments">У вас пока нет комментариев</p>
            @endforelse
        </div>
    </main>

    <!-- Оверлей редактирования -->
    <div class="edit-overlay" id="editOverlay">
        <div class="edit-modal">
            <button class="edit-close" onclick="closeEditOverlay()">✕</button>

            <!-- Превью обложки -->
            @if ($user->cover && $user->is_subscribed)
                <div class="edit-cover-preview" style="background-image: url('/storage/covers/{{ $user->cover }}');"></div>
            @else
                <div class="edit-cover-preview default-cover"></div>
            @endif

            <!-- Превью аватара -->
            <div class="edit-avatar-preview">
                @if ($user->avatar)
                    <img src="/storage/avatars/{{ $user->avatar }}" alt="Аватар" id="avatarPreview">
                @else
                    <div class="avatar-placeholder" id="avatarPreview"></div>
                @endif
            </div>

            <div class="edit-content">
                <h2 class="edit-title">{{ $user->name }} <span class="edit-username">{{ '@' . $user->username }}</span></h2>

                @if (session('success'))
                    <div class="edit-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="edit-errors">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="/profile/update" enctype="multipart/form-data" class="edit-form">
                    @csrf

                    <div class="edit-fields visible">
                        <label>Никнейм (уникальный)
                            <input type="text" name="username" value="{{ $user->username }}" required>
                        </label>
                        <label>Имя
                            <input type="text" name="name" value="{{ $user->name }}" required>
                        </label>
                        <label>Описание
                            <textarea name="bio" rows="3">{{ $user->bio }}</textarea>
                        </label>
                        <label>Аватар
                            <input type="file" name="avatar" accept="image/*" onchange="previewAvatar(this)">
                        </label>
                        @if ($user->is_subscribed)
                            <label>Обложка (только с подпиской)
                                <input type="file" name="cover" accept="image/*" onchange="previewCover(this)">
                            </label>
                        @endif
                    </div>

                    <button type="submit" class="btn-save">Сохранить изменения</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditOverlay() {
            document.getElementById('editOverlay').classList.add('active');
        }

        function closeEditOverlay() {
            document.getElementById('editOverlay').classList.remove('active');
        }

        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatarPreview');
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        preview.outerHTML = `<img src="${e.target.result}" alt="Аватар" id="avatarPreview">`;
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewCover(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.edit-cover-preview').style.backgroundImage = `url(${e.target.result})`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Закрытие по клику вне модалки
        document.getElementById('editOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditOverlay();
            }
        });
    </script>

@endsection
