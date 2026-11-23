@extends('blog.layout')
@inject('postContentSanitizer', 'App\Support\PostContentSanitizer')

@section('title', $post->title)
@section('description', $post->excerpt)

@section('content')
    <main class="lp-article">
        <div class="container">
            <a href="{{ url('/') }}#informasi" class="lp-link lp-article__back">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Semua informasi
            </a>

            <header class="lp-article__header">
                <p class="lp-post__meta">
                    <span class="lp-badge">{{ ucfirst($post->category) }}</span>
                    <time datetime="{{ $post->created_at?->toDateString() }}">
                        {{ $post->created_at?->locale('id')->translatedFormat('j F Y') }}
                    </time>
                    @if ($post->user)
                        <span>· {{ $post->user->name }}</span>
                    @endif
                </p>
                <h1 class="lp-article__title">{{ $post->title }}</h1>
            </header>

            @if ($post->gambar)
                <figure class="lp-article__figure">
                    <img src="{{ asset('storage/' . $post->gambar) }}" alt="">
                </figure>
            @endif

            <section class="post-content">
                <div class="lp-prose">
                    {!! $postContentSanitizer->sanitize($post->content) !!}
                </div>
            </section>

            @if ($previousPost || $nextPost)
                <nav class="lp-article__nav" aria-label="Informasi lainnya">
                    @if ($previousPost)
                        <a href="{{ route('blog.post', $previousPost->id) }}" class="lp-card lp-article__navlink">
                            <span>&larr; Sebelumnya</span>
                            <strong>{{ $previousPost->title }}</strong>
                        </a>
                    @endif
                    @if ($nextPost)
                        <a href="{{ route('blog.post', $nextPost->id) }}" class="lp-card lp-article__navlink lp-article__navlink--next">
                            <span>Berikutnya &rarr;</span>
                            <strong>{{ $nextPost->title }}</strong>
                        </a>
                    @endif
                </nav>
            @endif
        </div>
    </main>
@endsection
