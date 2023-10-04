@extends('blog.layout')

@section('content')
    <main class="blog-post">
        <div class="container">
            <h1 class="edica-page-title">{{ $post->title }}</h1>
            <p class="edica-blog-post-meta">{{ $post->user->name }} •
                {{ $post->updated_at }} • {{ $post->category }}</p>
            <section class="blog-post-featured-img">
                <img src="{{ asset('storage/' . $post->gambar) }}" alt="featured image" class="w-100">
            </section>
            <section class="post-content">
                <div class="row">
                    <div class="col-lg-9 mx-auto">
                        {!! $post->content !!}
                    </div>
                </div>
            </section>
            <div>
                <!-- Tombol Previous -->
                @if ($previousPost)
                    <a href="{{ route('blog.post', $previousPost->id) }}">Previous</a>
                @endif

                <!-- Tombol Next -->
                @if ($nextPost)
                    <a href="{{ route('blog.post', $nextPost->id) }}">Next</a>
                @endif
            </div>
        </div>
    </main>
@endsection
