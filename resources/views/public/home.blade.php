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
            <div class="row align-items-center pt-5 pb-5" style="min-height: calc(100vh - 100px);">
                <div class="col-lg-8 col-xl-7">
                    <p class="section-label text-white opacity-75 mb-3">Selamat Datang di</p>
                    <h1 class="display-4 fw-bold text-white mb-4">
                        {{ $settings['hero_title'] ?? 'Desa Wisata Kawengan' }}
                    </h1>
                    <p class="lead text-white opacity-90 mb-5">
                        {{ $settings['hero_subtitle'] ?? 'Jelajahi keindahan alam, budaya, dan keramahan desa kami dalam satu petualangan yang tak terlupakan.' }}
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('destinations.index') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-map me-2"></i>Jelajahi Destinasi
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">
                            Tentang Desa
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="row g-2 g-md-3 mt-4 mt-md-5 pt-2 pt-md-3">
                        <div class="col-4 col-md-3">
                            <div class="text-white text-center text-md-start">
                                <h3 class="fw-bold mb-1">{{ $destinations->count() }}+</h3>
                                <p class="small opacity-75 mb-0">Destinasi</p>
                            </div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="text-white text-center text-md-start">
                                <h3 class="fw-bold mb-1">{{ $galleries->count() }}+</h3>
                                <p class="small opacity-75 mb-0">Galeri</p>
                            </div>
                        </div>
                        @if(\App\Models\SiteSetting::get('feature_news') == '1')
                            <div class="col-4 col-md-3">
                                <div class="text-white text-center text-md-start">
                                    <h3 class="fw-bold mb-1">{{ $posts->count() }}+</h3>
                                    <p class="small opacity-75 mb-0">Berita</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="hero-scroll d-none d-md-flex">
            <span>Jelajahi</span>
            <i class="bi bi-chevron-down fs-5"></i>
        </div>
    </section>

    {{-- DESTINASI WISATA --}}
    <section class="py-section">
        <div class="container">
            {{-- Header Destinasi --}}
            <div class="d-flex justify-content-between align-items-start align-items-md-end flex-column flex-md-row mb-5">
                <div>
                    <p class="section-label">Temukan</p>
                    <h2 class="section-title">Destinasi Wisata</h2>
                    <p class="section-subtitle d-none d-md-block">Jelajahi tempat-tempat menarik di
                        {{ $settings['site_name'] ?? 'desa kami' }}</p>
                </div>
                <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary mt-3 mt-md-0">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            @if($destinations->count() > 0)
                <div class="row g-4">
                    @foreach($destinations as $destination)
                        <div class="col-lg-3 col-md-6">
                            <div class="card destination-card h-100">
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
                                    <a href="{{ route('destinations.show', $destination->slug) }}" class="card-link mt-auto">
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
    <section class="py-section" style="background-color: var(--section-bg-alt)">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 order-2 order-lg-1">
                    <p class="section-label">Mengenal Kami</p>
                    <h2 class="section-title">Tentang {{ $settings['site_name'] ?? 'Desa Kami' }}</h2>
                    <div class="mt-3 mb-4" style="color: var(--card-muted)">
                        {!! Str::limit(strip_tags($settings['about_content'] ?? ''), 320) !!}
                    </div>
                    <a href="{{ route('about') }}" class="card-link d-inline-flex">
                        Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    @if(!empty($settings['hero_image']))
                        <img src="{{ Storage::url($settings['hero_image']) }}"
                            alt="{{ $settings['site_name'] ?? 'Desa Wisata' }}"
                            class="img-fluid rounded-xl shadow w-100"
                            style="aspect-ratio: 4/3; object-fit: cover;">
                    @else
                        <div class="rounded-xl d-flex align-items-center justify-content-center w-100"
                            style="aspect-ratio:4/3; background-color: var(--section-bg-alt)">
                            <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- GALERI --}}
    @if($galleries->count() > 0)
        <section class="py-section">
            <div class="container">
                <div class="d-flex justify-content-between align-items-start align-items-md-end flex-column flex-md-row mb-5">
                    <div>
                        <p class="section-label">Dokumentasi</p>
                        <h2 class="section-title">Galeri Foto</h2>
                        <p class="section-subtitle d-none d-md-block">Momen-momen indah di {{ $settings['site_name'] ?? 'desa kami' }}</p>
                    </div>
                    <a href="{{ route('gallery') }}" class="btn btn-outline-primary mt-3 mt-md-0">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-3">
                    @foreach($galleries as $photo)
                        <div class="col-6 col-md-4 col-lg-3">
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
        <section class="py-section" style="background-color: var(--section-bg-alt)">
            <div class="container">
                <div class="d-flex justify-content-between align-items-start align-items-md-end flex-column flex-md-row mb-5">
                    <div>
                        <p class="section-label">Informasi Terkini</p>
                        <h2 class="section-title">Berita Terbaru</h2>
                        <p class="section-subtitle d-none d-md-block">Update terbaru dari {{ $settings['site_name'] ?? 'desa kami' }}</p>
                    </div>
                    <a href="{{ route('news.index') }}" class="btn btn-outline-primary mt-3 mt-md-0">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <div class="card destination-card h-100">
                                @if($post->thumbnail)
                                    <img src="{{ Storage::url($post->thumbnail) }}" class="card-img-top" alt="{{ $post->title }}">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center"
                                        style="aspect-ratio:16/9; background-color: var(--card-bg)">
                                        <i class="bi bi-newspaper fs-1 text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <p class="small mb-2" style="color: var(--card-muted)">
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

    {{-- CTA SECTION --}}
    <section class="cta-section">
        <div class="container position-relative z-1">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold mb-3">Siap Berpetualang di {{ $settings['site_name'] ?? 'Desa Kami' }}?</h2>
                    <p class="lead opacity-90 mb-4">Hubungi kami sekarang dan mulai perjalanan wisata desa yang penuh kesan.</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        @if(\App\Models\SiteSetting::get('contact_phone'))
                            <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_phone') }}" target="_blank"
                                class="btn btn-light btn-lg">
                                <i class="bi bi-whatsapp me-2"></i>Hubungi via WhatsApp
                            </a>
                        @endif
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                            Lihat Kontak
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
