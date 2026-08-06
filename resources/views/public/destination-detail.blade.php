@extends('layouts.app')

@section('title', $destination->name . ' - ' . \App\Models\SiteSetting::get('site_name', 'Desa Wisata'))

@section('content')

    {{-- PAGE HEADER --}}
    <section style="padding: 95px 0 40px; background-color: var(--bs-tertiary-bg)">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary)">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('destinations.index') }}" class="text-decoration-none"
                            style="color: var(--primary)">Destinasi Wisata</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $destination->name }}</li>
                </ol>
            </nav>
            <h1 class="section-title">{{ $destination->name }}</h1>
            @if($destination->address)
                <p class="text-muted">
                    <i class="bi bi-geo-alt me-1"></i>{{ $destination->address }}
                </p>
            @endif
        </div>
    </section>

    {{-- KONTEN UTAMA --}}
    <section style="padding: 60px 0">
        <div class="container">
            <div class="row g-5">

                {{-- Kolom Kiri: Foto + Galeri --}}
                <div class="col-lg-7">

                    {{-- Foto Utama --}}
                    @if($destination->thumbnail)
                        <a href="{{ Storage::url($destination->thumbnail) }}" class="glightbox d-block mb-3"
                            data-gallery="destination-gallery">
                            <img src="{{ Storage::url($destination->thumbnail) }}" alt="{{ $destination->name }}"
                                class="img-fluid rounded-xl w-100"
                                style="aspect-ratio: 16/9; object-fit: contain; background-color: var(--card-bg)">
                        </a>
                    @endif

                    @if($images->count() > 0)
                        <div class="position-relative mt-3">
                            <button class="btn btn-sm position-absolute start-0 top-50 translate-middle-y z-1 d-none d-lg-flex"
                                style="background: var(--primary); color: white; border-radius: 50%; width:32px; height:32px; padding:0; align-items:center; justify-content:center; margin-left: -16px"
                                id="scrollLeft">
                                <i class="bi bi-chevron-left"></i>
                            </button>

                            <div class="d-flex gap-2 overflow-auto pb-2 dest-gallery-scroll" id="destGallery">
                                @foreach($images as $image)
                                    <a href="{{ Storage::url($image->image_path) }}" class="glightbox flex-shrink-0"
                                        data-gallery="destination-gallery" data-description="{{ $image->caption }}">
                                        <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->caption }}"
                                            class="rounded dest-thumb">
                                    </a>
                                @endforeach
                            </div>

                            <button class="btn btn-sm position-absolute end-0 top-50 translate-middle-y z-1 d-none d-lg-flex"
                                style="background: var(--primary); color: white; border-radius: 50%; width:32px; height:32px; padding:0; align-items:center; justify-content:center; margin-right: -16px"
                                id="scrollRight">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    @endif

                </div>

                {{-- Kolom Kanan: Info --}}
                <div class="col-lg-5">

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <p class="section-label">Tentang Destinasi</p>
                        <div style="line-height: 1.8; color: var(--bs-body-color)">
                            {!! nl2br(e($destination->description)) !!}
                        </div>
                    </div>

                    {{-- Alamat --}}
                    @if($destination->address)
                        <div class="mb-4 p-3 rounded-xl" style="background-color: var(--bs-tertiary-bg)">
                            <p class="section-label mb-2">Lokasi</p>
                            <p class="mb-0 small">
                                <i class="bi bi-geo-alt-fill me-2" style="color: var(--primary)"></i>
                                {{ $destination->address }}
                            </p>
                        </div>
                    @endif

                    {{-- Tombol WhatsApp --}}
                    @if(\App\Models\SiteSetting::get('contact_phone'))
                        <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_phone') }}" target="_blank"
                            class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-whatsapp me-2"></i>Hubungi Kami via WhatsApp
                        </a>
                    @endif

                    <a href="{{ route('destinations.index') }}" class="card-link">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Destinasi
                    </a>

                </div>
            </div>

            {{-- Google Maps --}}
            @if($destination->gmaps_embed || $destination->gmaps_link)
                <div class="mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="section-label mb-0">Peta Lokasi</p>
                        @if($destination->gmaps_link)
                            <a href="{{ $destination->gmaps_link }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Buka di Google Maps
                            </a>
                        @endif
                    </div>
                    @if($destination->gmaps_embed)
                        <div class="maps-container">
                            {!! $destination->gmaps_embed !!}
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </section>

    @push('scripts')
        <script>
            // Scroll gallery
            const gallery = document.getElementById('destGallery');
            document.getElementById('scrollLeft')?.addEventListener('click', () => {
                gallery.scrollBy({ left: -220, behavior: 'smooth' });
            });
            document.getElementById('scrollRight')?.addEventListener('click', () => {
                gallery.scrollBy({ left: 220, behavior: 'smooth' });
            });
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