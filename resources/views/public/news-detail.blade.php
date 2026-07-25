@extends('layouts.app')

@section('title', $post->title . ' - ' . \App\Models\SiteSetting::get('site_name', 'Desa Wisata'))

@section('content')

{{-- PAGE HEADER --}}
<section style="padding: 60px 0 40px; background-color: var(--bs-tertiary-bg)">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary)">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('news.index') }}" class="text-decoration-none" style="color: var(--primary)">Berita</a>
                </li>
                <li class="breadcrumb-item active">{{ Str::limit($post->title, 40) }}</li>
            </ol>
        </nav>
        <p class="small text-muted mb-2">
            <i class="bi bi-calendar3 me-1"></i>
            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
        </p>
        <h1 class="section-title">{{ $post->title }}</h1>
        @if($post->excerpt)
        <p class="section-subtitle">{{ $post->excerpt }}</p>
        @endif
    </div>
</section>

{{-- KONTEN BERITA --}}
<section style="padding: 60px 0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Thumbnail --}}
                @if($post->thumbnail)
                <img src="{{ Storage::url($post->thumbnail) }}"
                     alt="{{ $post->title }}"
                     class="img-fluid rounded-xl w-100 mb-4"
                     style="aspect-ratio: 16/9; object-fit: contain; background-color: var(--card-bg)">
                @endif

                {{-- Isi Berita --}}
                <div class="content-body" style="line-height: 1.9">
                    {!! $post->content !!}
                </div>

                <hr class="my-4">

                <a href="{{ route('news.index') }}" class="card-link">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Berita
                </a>

            </div>
        </div>
    </div>
</section>

@endsection