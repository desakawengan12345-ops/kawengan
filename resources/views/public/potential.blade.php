@extends('layouts.app')

@section('title', 'Peta Potensi - ' . \App\Models\SiteSetting::get('site_name', 'Desa Wisata'))

@section('content')

{{-- PAGE HEADER --}}
<section style="padding: 60px 0 40px; background-color: var(--bs-tertiary-bg)">
    <div class="container">
        <p class="section-label">Potensi Desa</p>
        <h1 class="section-title">Peta Potensi</h1>
        <p class="section-subtitle">Potensi unggulan yang dimiliki {{ \App\Models\SiteSetting::get('site_name', 'desa kami') }}</p>
    </div>
</section>

{{-- KONTEN PETA POTENSI --}}
<section style="padding: 60px 0">
    <div class="container">

        @if(!empty($settings['potential_image']) || !empty($settings['potential_description']))
            <div class="row g-5 align-items-start">

                {{-- Foto Peta Potensi --}}
                @if(!empty($settings['potential_image']))
                    <div class="col-lg-8">
                        <a href="{{ Storage::url($settings['potential_image']) }}"
                           class="glightbox d-block"
                           data-gallery="potential">
                            <img src="{{ Storage::url($settings['potential_image']) }}"
                                 alt="Peta Potensi {{ \App\Models\SiteSetting::get('site_name', 'Desa') }}"
                                 class="img-fluid rounded-xl shadow w-100"
                                 style="aspect-ratio: 16/9; object-fit: contain; background-color: var(--card-bg)">
                        </a>
                    </div>
                @endif

                {{-- Deskripsi --}}
                @if(!empty($settings['potential_description']))
                    <div class="{{ !empty($settings['potential_image']) ? 'col-lg-4' : 'col-lg-8' }}">
                        <p class="section-label">Keterangan</p>
                        <div class="content-body" style="line-height: 1.9">
                            {!! nl2br(e($settings['potential_description'])) !!}
                        </div>
                    </div>
                @endif

            </div>

        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-map fs-1 mb-3 d-block"></i>
                <p>Peta potensi belum tersedia.</p>
            </div>
        @endif

    </div>
</section>

{{-- CTA --}}
<section style="padding: 60px 0; background-color: var(--bs-tertiary-bg)">
    <div class="container text-center">
        <p class="section-label">Selanjutnya</p>
        <h2 class="section-title mb-3">Jelajahi Destinasi Wisata</h2>
        <p class="text-muted mb-4">Temukan tempat-tempat menarik yang bisa kamu kunjungi di {{ \App\Models\SiteSetting::get('site_name', 'desa kami') }}</p>
        <a href="{{ route('destinations.index') }}" class="btn btn-primary btn-lg px-5">
            <i class="bi bi-map me-2"></i>Lihat Destinasi
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
    if (typeof GLightbox !== 'undefined') {
        GLightbox({
            touchNavigation: true,
            loop: false,
            closeButton: true,
        });
    }
</script>
@endpush