@extends('layouts.app')

@section('title', 'Kontak - Desa Wisata Kawengan')

@section('content')

{{-- PAGE HEADER --}}
<section style="padding: 60px 0 40px; background-color: var(--bs-tertiary-bg)">
    <div class="container">
        <p class="section-label">Hubungi Kami</p>
        <h1 class="section-title">Kontak</h1>
        <p class="section-subtitle">Jangan ragu untuk menghubungi kami</p>
    </div>
</section>

{{-- KONTEN KONTAK --}}
<section style="padding: 60px 0">
    <div class="container">
        <div class="row g-5">

            {{-- Kolom Kiri: Info Kontak --}}
            <div class="col-lg-5">
                <p class="section-label">Informasi</p>
                <h2 class="section-title mb-4">Temukan Kami</h2>

                {{-- Kartu Info --}}
                <div class="d-flex flex-column gap-3">

                    @if(\App\Models\SiteSetting::get('contact_phone'))
                    <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_phone') }}"
                       target="_blank"
                       class="d-flex gap-3 align-items-center p-3 rounded-xl text-decoration-none"
                       style="background-color: var(--bs-tertiary-bg)">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                             style="width:44px; height:44px; background-color: rgba(74,124,89,0.15)">
                            <i class="bi bi-whatsapp fs-5 text-success"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 small" style="color: var(--bs-body-color)">WhatsApp</p>
                            <p class="mb-0 small text-muted">{{ \App\Models\SiteSetting::get('contact_phone') }}</p>
                        </div>
                    </a>
                    @endif

                    @if(\App\Models\SiteSetting::get('contact_email'))
                    <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email') }}"
                       class="d-flex gap-3 align-items-center p-3 rounded-xl text-decoration-none"
                       style="background-color: var(--bs-tertiary-bg)">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                             style="width:44px; height:44px; background-color: rgba(74,124,89,0.15)">
                            <i class="bi bi-envelope fs-5" style="color: var(--primary)"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 small" style="color: var(--bs-body-color)">Email</p>
                            <p class="mb-0 small text-muted">{{ \App\Models\SiteSetting::get('contact_email') }}</p>
                        </div>
                    </a>
                    @endif

                    @if(\App\Models\SiteSetting::get('contact_address'))
                    <div class="d-flex gap-3 align-items-center p-3 rounded-xl"
                         style="background-color: var(--bs-tertiary-bg)">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                             style="width:44px; height:44px; background-color: rgba(74,124,89,0.15)">
                            <i class="bi bi-geo-alt fs-5" style="color: var(--primary)"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 small" style="color: var(--bs-body-color)">Alamat</p>
                            <p class="mb-0 small text-muted">{{ \App\Models\SiteSetting::get('contact_address') }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Media Sosial --}}
                    @if(\App\Models\SiteSetting::get('social_instagram') || \App\Models\SiteSetting::get('social_facebook'))
                    <div class="mt-2">
                        <p class="fw-semibold small mb-2">Ikuti Kami</p>
                        <div class="d-flex gap-2">
                            @if(\App\Models\SiteSetting::get('social_instagram'))
                            <a href="{{ \App\Models\SiteSetting::get('social_instagram') }}"
                               target="_blank"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-instagram me-1"></i>Instagram
                            </a>
                            @endif
                            @if(\App\Models\SiteSetting::get('social_facebook'))
                            <a href="{{ \App\Models\SiteSetting::get('social_facebook') }}"
                               target="_blank"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-facebook me-1"></i>Facebook
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Kolom Kanan: Google Maps --}}
            <div class="col-lg-7">
                <p class="section-label">Lokasi</p>
                <h2 class="section-title mb-4">Peta Lokasi Desa</h2>
                @if(\App\Models\SiteSetting::get('contact_gmaps'))
                <div class="maps-container rounded-xl overflow-hidden">
                    {!! \App\Models\SiteSetting::get('contact_gmaps') !!}
                </div>
                @else
                <div class="d-flex align-items-center justify-content-center rounded-xl text-muted"
                     style="height:400px; background-color: var(--bs-tertiary-bg)">
                    <div class="text-center">
                        <i class="bi bi-map fs-1 mb-3 d-block"></i>
                        <p class="small">Peta belum dikonfigurasi</p>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection