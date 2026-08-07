@extends('layouts.app')

@section('title', 'Berita - ' . \App\Models\SiteSetting::get('site_name', 'Desa Wisata'))

@section('content')

{{-- PAGE HEADER --}}
<section style="padding: 95px 0 40px; background-color: var(--bs-tertiary-bg)">
    <div class="container">
        <p class="section-label">Informasi Terkini</p>
        <h1 class="section-title">Berita</h1>
        <p class="section-subtitle">Update terbaru dari {{ \App\Models\SiteSetting::get('site_name', 'desa kami') }}</p>
    </div>
</section>

{{-- LIST BERITA --}}
<section style="padding: 60px 0">
    <div class="container">
        @if($posts->count() > 0)
        <div class="row g-4">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="card destination-card shadow-sm h-100 position-relative">
                    <a href="{{ route('news.show', $post->slug) }}"
                       class="card-mobile-link d-lg-none stretched-link"
                       aria-label="Baca berita {{ $post->title }}"></a>
                    @if($post->thumbnail)
                    <img src="{{ Storage::url($post->thumbnail) }}"
                         class="card-img-top"
                         alt="{{ $post->title }}">
                    @else
                    <div class="card-img-top d-flex align-items-center justify-content-center"
                         style="aspect-ratio:16/9; background-color: var(--card-bg)">
                        <i class="bi bi-newspaper fs-1 text-muted"></i>
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <p class="small text-muted mb-1">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </p>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        @if($post->excerpt)
                        <p class="card-text flex-grow-1">
                            {{ Str::limit($post->excerpt, 100) }}
                        </p>
                        @endif
                        <a href="{{ route('news.show', $post->slug) }}" class="card-link mt-2 position-relative" style="z-index: 2;">
                            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-newspaper fs-1 mb-3 d-block"></i>
            <p>Belum ada berita yang tersedia.</p>
        </div>
        @endif
    </div>
</section>

@endsection