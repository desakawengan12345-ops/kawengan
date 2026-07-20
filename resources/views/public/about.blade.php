@extends('layouts.app')

@section('title', 'Tentang Desa - Desa Wisata Kawengan')

@section('content')

    {{-- PAGE HEADER --}}
    <section style="padding: 60px 0 40px; background-color: var(--bs-tertiary-bg)">
        <div class="container">
            <p class="section-label">Mengenal Kami</p>
            <h1 class="section-title">Tentang Desa Kawengan</h1>
            <p class="section-subtitle">Kenali lebih dalam tentang desa kami</p>
        </div>
    </section>

    {{-- PROFIL DESA --}}
    <section style="padding: 60px 0">
        <div class="container">
            <div class="row g-5 align-items-start">

                {{-- Konten Kiri --}}
                <div class="col-lg-6">
                    <p class="section-label">{{ $settings['about_title'] ?? 'Tentang Desa' }}</p>
                    <h2 class="section-title mb-4">Profil Desa</h2>

                    {{-- Foto (tampil di sini saat mobile, setelah judul) --}}
                    @if(!empty($settings['hero_image']))
                        <div class="d-lg-none mb-4">
                            <img src="{{ Storage::url($settings['hero_image']) }}" alt="Desa Kawengan"
                                class="img-fluid rounded-xl shadow w-100">
                        </div>
                    @endif

                    {{-- Info Kontak (tampil di sini saat mobile) --}}
                    <div class="d-lg-none mb-4">
                        <div class="p-3 rounded-xl d-inline-block" style="background-color: var(--bs-tertiary-bg)">
                            @if(\App\Models\SiteSetting::get('contact_phone'))
                                <div class="d-flex gap-2 align-items-center small">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    <span>{{ \App\Models\SiteSetting::get('contact_phone') }}</span>
                                </div>
                            @endif
                            @if(\App\Models\SiteSetting::get('contact_email'))
                                <div class="d-flex gap-2 small mt-2">
                                    <i class="bi bi-envelope mt-1" style="color: var(--primary)"></i>
                                    <span>{{ \App\Models\SiteSetting::get('contact_email') }}</span>
                                </div>
                            @endif
                            @if(\App\Models\SiteSetting::get('contact_address'))
                                <div class="d-flex gap-2 small mt-2">
                                    <i class="bi bi-geo-alt mt-1" style="color: var(--primary)"></i>
                                    <span>{{ \App\Models\SiteSetting::get('contact_address') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="content-body" style="line-height: 1.9">
                        {!! $settings['about_content'] ?? '<p>Konten profil desa belum tersedia.</p>' !!}
                    </div>
                </div>

                {{-- Kolom Kanan (hanya tampil di PC) --}}
                <div class="col-lg-6 d-none d-lg-block">
                    @if(!empty($settings['hero_image']))
                        <img src="{{ Storage::url($settings['hero_image']) }}" alt="Desa Kawengan"
                            class="img-fluid rounded-xl shadow w-100" style="aspect-ratio: 4/3; object-fit: cover">
                    @endif

                    {{-- Info Kontak PC --}}
                    <div class="mt-4 p-3 rounded-xl d-inline-block" style="background-color: var(--bs-tertiary-bg)">
                        <h6 class="fw-bold mb-3">Informasi Kontak</h6>
                        @if(\App\Models\SiteSetting::get('contact_phone'))
                            <div class="d-flex gap-2 align-items-center small mb-2">
                                <i class="bi bi-whatsapp text-success"></i>
                                <span>{{ \App\Models\SiteSetting::get('contact_phone') }}</span>
                            </div>
                        @endif
                        @if(\App\Models\SiteSetting::get('contact_email'))
                            <div class="d-flex gap-2 align-items-center small mb-2">
                                <i class="bi bi-envelope mt-1" style="color: var(--primary)"></i>
                                <span>{{ \App\Models\SiteSetting::get('contact_email') }}</span>
                            </div>
                        @endif
                        @if(\App\Models\SiteSetting::get('contact_address'))
                            <div class="d-flex gap-2 align-items-center small mb-2">
                                <i class="bi bi-geo-alt mt-1" style="color: var(--primary)"></i>
                                <span>{{ \App\Models\SiteSetting::get('contact_address') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- SEJARAH DESA --}}
    <section style="padding: 60px 0; background-color: var(--bs-tertiary-bg)">
        <div class="container">
            <p class="section-label">{{ $settings['history_title'] ?? 'Sejarah' }}</p>
            <h2 class="section-title mb-4">Sejarah Desa</h2>
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-body" style="line-height: 1.9">
                        {!! $settings['history_content'] ?? '<p>Konten sejarah desa belum tersedia.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section style="padding: 60px 0">
        <div class="container text-center">
            <p class="section-label">Selanjutnya</p>
            <h2 class="section-title mb-3">Jelajahi Destinasi Wisata</h2>
            <p class="text-muted mb-4">Temukan tempat-tempat menarik yang bisa kamu kunjungi di Desa Kawengan</p>
            <a href="{{ route('destinations.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-map me-2"></i>Lihat Destinasi
            </a>
        </div>
    </section>

@endsection