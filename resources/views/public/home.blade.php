@extends('layouts.app')

@section('title', 'Beranda - ' . \App\Models\SiteSetting::get('site_name', 'Desa Wisata'))

@section('content')

    {{-- HERO --}}
    <section class="hero-section">
        <div class="hero-bg"
            style="background-image: url('{{ $settings['hero_image'] ? Storage::url($settings['hero_image']) : 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920' }}')">
        </div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-7">
                    <p class="section-label text-white opacity-75 mb-2">Selamat Datang</p>
                    <h1 class="display-4 fw-bold text-white mb-3">
                        {{ $settings['hero_title'] ?? 'Desa Wisata Kawengan' }}
                    </h1>
                    <p class="lead text-white opacity-75 mb-4">
                        {{ $settings['hero_subtitle'] ?? 'Jelajahi keindahan dan budaya desa kami' }}
                    </p>
                    <div class="d-flex gap-3 flex-wrap mt-4">
                        <a href="{{ route('destinations.index') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-map me-2"></i>Jelajahi Destinasi
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">
                            Tentang Desa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- DESTINASI WISATA --}}
    <section class="py-6" style="padding: 80px 0">
        <div class="container">
            {{-- Header Destinasi --}}
            <div class="d-flex justify-content-between align-items-start align-items-md-end flex-column flex-md-row mb-4">
                <div>
                    <p class="section-label">Temukan</p>
                    <h2 class="section-title">Destinasi Wisata</h2>
                    <p class="section-subtitle d-none d-md-block">Jelajahi tempat-tempat menarik di
                        {{ $settings['site_name'] ?? 'desa kami' }}</p>
                </div>
                <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary mt-2 mt-md-0">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            @if($destinations->count() > 0)
                <div class="row g-4">
                    @foreach($destinations as $destination)
                        <div class="col-lg-3 col-md-6">
                            <div class="card destination-card shadow-sm">
                                @if($destination->thumbnail)
                                    <img src="{{ Storage::url($destination->thumbnail) }}" class="card-img-top"
                                        alt="{{ $destination->name }}">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                        style="height:220px">
                                        <i class="bi bi-image text-white fs-1"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $destination->name }}</h5>
                                    <p class="card-text flex-grow-1">
                                        {{ Str::limit(strip_tags($destination->description), 120) }}
                                    </p>
                                    <a href="{{ route('destinations.show', $destination->slug) }}" class="card-link">
                                        Selengkapnya <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-map fs-1 mb-3 d-block"></i>
                    <p>Belum ada destinasi wisata yang tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- TENTANG DESA --}}
    <section style="padding: 80px 0; background-color: var(--bs-tertiary-bg)">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <p class="section-label">Mengenal Kami</p>
                    <h2 class="section-title">Tentang {{ $settings['site_name'] ?? 'Desa Kami' }}</h2>
                    <div class="text-muted mt-3">
                        {!! Str::limit(strip_tags($settings['about_content'] ?? ''), 300) !!}
                    </div>
                    <a href="{{ route('about') }}" class="card-link mt-4 d-inline-flex">
                        Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-6">
                    @if(!empty($settings['hero_image']))
                        <img src="{{ Storage::url($settings['hero_image']) }}"
                            alt="{{ $settings['site_name'] ?? 'Desa Wisata' }}" class="img-fluid rounded-xl shadow">
                    @else
                        <div class="bg-secondary rounded-xl d-flex align-items-center justify-content-center"
                            style="height:350px">
                            <i class="bi bi-image text-white fs-1"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- GALERI --}}
    @if($galleries->count() > 0)
        <section style="padding: 80px 0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-start align-items-md-end flex-column flex-md-row mb-4">
                    <div class="col">
                        <p class="section-label">Dokumentasi</p>
                        <h2 class="section-title">Galeri Foto</h2>
                        <p class="section-subtitle">Momen-momen indah di {{ $settings['site_name'] ?? 'desa kami' }}</p>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('gallery') }}" class="btn btn-outline-primary">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="row g-2 g-md-3">
                    @foreach($galleries as $photo)
                        <div class="col-6 col-md-4">
                            <a href="{{ Storage::url($photo->image_path) }}" class="glightbox d-block" data-gallery="gallery-home"
                                data-description="{{ $photo->caption }}">
                                <div class="gallery-item gallery-home-item">
                                    <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->caption }}">
                                    <div class="gallery-overlay">
                                        <i class="bi bi-zoom-in text-white fs-3"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    {{-- BERITA --}}
    @if($posts->count() > 0)
        <section style="padding: 80px 0; background-color: var(--bs-tertiary-bg)">
            <div class="container">
                <div class="d-flex justify-content-between align-items-start align-items-md-end flex-column flex-md-row mb-4">
                    <div>
                        <p class="section-label">Informasi Terkini</p>
                        <h2 class="section-title">Berita Terbaru</h2>
                        <p class="section-subtitle d-none d-md-block">Update terbaru dari {{ $settings['site_name'] ?? 'desa kami' }}</p>
                    </div>
                    <a href="{{ route('news.index') }}" class="btn btn-outline-primary mt-2 mt-md-0">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <div class="card destination-card shadow-sm h-100">
                                @if($post->thumbnail)
                                    <img src="{{ Storage::url($post->thumbnail) }}" class="card-img-top" alt="{{ $post->title }}">
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
                                    <a href="{{ route('news.show', $post->slug) }}" class="card-link mt-2">
                                        Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- PETA POTENSI --}}
@if(!empty($settings['feature_potential']) && $settings['feature_potential'] == '1' && !empty($settings['potential_image']))
    <section style="padding: 80px 0">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start align-items-md-end flex-column flex-md-row mb-4">
                <div>
                    <p class="section-label">Potensi Desa</p>
                    <h2 class="section-title">Peta Potensi</h2>
                    <p class="section-subtitle d-none d-md-block">Potensi unggulan {{ $settings['site_name'] ?? 'desa kami' }}</p>
                </div>
                <a href="{{ route('potential') }}" class="btn btn-outline-primary mt-2 mt-md-0">
                    Lihat Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <img src="{{ Storage::url($settings['potential_image']) }}"
                 alt="Peta Potensi {{ $settings['site_name'] ?? 'Desa' }}"
                 class="img-fluid rounded-xl shadow w-100"
                 style="aspect-ratio: 16/9; object-fit: contain; background-color: var(--card-bg)">
        </div>
    </section>
@endif

    {{-- KONTAK SINGKAT --}}
    <section style="padding: 80px 0; background-color: var(--primary)">
        <div class="container text-center text-white">
            <h2 class="fw-bold mb-3">Hubungi Kami</h2>
            <p class="opacity-75 mb-4">Ada pertanyaan atau ingin berkunjung? Jangan ragu untuk menghubungi kami.</p>
            <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-5">
                <i class="bi bi-envelope me-2"></i>Kontak Kami
            </a>
        </div>
    </section>

    @push('scripts')
        <script>
            if (typeof GLightbox !== 'undefined') {
                GLightbox({
                    touchNavigation: true,
                    loop: true,
                    closeButton: true,
                });
            }
        </script>
    @endpush
@endsection