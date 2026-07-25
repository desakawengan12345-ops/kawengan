@extends('layouts.app')

@section('title', 'Destinasi Wisata - ' . \App\Models\SiteSetting::get('site_name', 'Desa Wisata'))

@section('content')

{{-- PAGE HEADER --}}
<section style="padding: 60px 0 40px; background-color: var(--bs-tertiary-bg)">
    <div class="container">
        <p class="section-label">Jelajahi</p>
        <h1 class="section-title">Destinasi Wisata</h1>
        <p class="section-subtitle">Temukan tempat-tempat menarik di {{ \App\Models\SiteSetting::get('site_name', 'desa kami') }}</p>
    </div>
</section>

{{-- LIST DESTINASI --}}
<section style="padding: 60px 0">
    <div class="container">
        @if($destinations->count() > 0)
        <div class="row g-4">
            @foreach($destinations as $destination)
            <div class="col-lg-3 col-md-6">
                <div class="card destination-card shadow-sm">
                    @if($destination->thumbnail)
                    <img src="{{ Storage::url($destination->thumbnail) }}"
                         class="card-img-top" alt="{{ $destination->name }}">
                    @else
                    <div class="card-img-top d-flex align-items-center justify-content-center"
                         style="aspect-ratio:16/9; background-color: var(--card-bg)">
                        <i class="bi bi-image fs-1 text-muted"></i>
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

@endsection