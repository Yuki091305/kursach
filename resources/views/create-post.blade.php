@extends('layouts.community')

@section('title', 'Создать пост — Coelesti')

@section('content')

    <main class="create-post-page">
        <div class="create-post-card">
            <h1 class="create-post-title">Заголовок</h1>

            @if ($errors->any())
                <div class="form-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/create-post" enctype="multipart/form-data" class="create-post-form">
                @csrf

                <!-- Область для картинки -->
                <div class="image-upload-area" id="imageUploadArea">
                    <div id="uploadPlaceholder">
                        <label class="upload-btn" for="imageInput">Добавить изображение</label>
                        <input type="file" name="image" id="imageInput" accept="image/*" style="display:none;" onchange="previewImage(this)">
                    </div>
                    <img id="imagePreview" style="display:none; max-width:100%; border-radius:12px;">
                </div>

                <!-- Текстовое поле -->
                <textarea name="content" class="post-textarea" placeholder="Текстовое поле">{{ old('content') }}</textarea>

                <!-- Заголовок (скрытое поле, заполняется через JS или отдельное поле) -->
                <input type="text" name="title" value="{{ old('title', 'Новый пост') }}" style="display:none;">

                <div class="create-post-actions">
                    <a href="/profile" class="btn-cancel">Отменить</a>
                    <button type="submit" class="btn-publish">Опубликовать</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    const placeholder = document.getElementById('uploadPlaceholder');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection
