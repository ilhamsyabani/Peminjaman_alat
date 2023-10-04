@extends('blog.layout')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mt-4 ">
                        <h2 class="edica-landing-section-title mt-4">Peminjaman LAP TP</h2>
                        <p>Gunakan aplkasi untuk dapat menikamti akses penuh fasilaitas di lap TP</p>
                        <ul class="landing-about-list">
                            <li>Peminjamaan Barang</li>
                            <li>Reservasi Ruangan</li>
                            <li>Konsultasi Tugas Akhir</li>
                            <li>Pelatihan Pemanfaatan dan Pengembangan Teknologi</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <img src="assets/images/phone-copy.png" width="468px" alt="about" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="edica-landing-section edica-landing-blog">
            <div class="container">
                <h4 class="edica-landing-section-subtitle">Blog posts</h4>
                <h2 class="edica-landing-section-title">Informasi Terbaru Seputar <br> LAP TP FIP UNY.</h2>
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-md-4 landing-blog-post">
                            <img src="{{ asset('storage/' . $post->gambar) }}" alt="blog post" class="blog-post-thumbnail">
                            <p class="blog-post-category">{{ $post->category }}</p>
                            <h4 class="blog-post-title">{{ $post->title }}</h4>
                            <p style="font-size: 16px;">{{ $post->excerpt }} <br><a href="{{ route('blog.post', ['post' => $post]) }}" class="blog-post-link">Learn more</a></p>
                        </div>
                    @endforeach
                    {{ $posts->links() }}
                </div>
            </div>
        </section>
    </main>
@endsection
