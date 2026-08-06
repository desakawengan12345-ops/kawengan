@extends('layouts.app')

@section('title', 'Galeri - ' . \App\Models\SiteSetting::get('site_name', 'Desa Wisata'))

@section('content')

    {{-- PAGE HEADER --}}
    <section style="padding: 95px 0 40px; background-color: var(--bs-tertiary-bg)">
        <div class="container">
            <p class="section-label">Dokumentasi</p>
            <h1 class="section-title">Galeri Foto</h1>
            <p class="section-subtitle">Momen-momen indah di {{ \App\Models\SiteSetting::get('site_name', 'desa kami') }}</p>
            {{-- Filter Kategori --}}
            <div class="d-flex gap-2 flex-wrap mt-3">
                <button class="btn btn-primary btn-sm filter-btn active" data-filter="all">
                    Semua
                </button>
                <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="kegiatan">
                    Kegiatan
                </button>
                <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="pemandangan">
                    Pemandangan
                </button>
                <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="budaya">
                    Budaya
                </button>
            </div>
        </div>
    </section>

    {{-- GRID FOTO --}}
    <section style="padding: 60px 0">
        <div class="container">
            @if($galleries->count() > 0)
                <div class="row g-3" id="galleryGrid">
                    @foreach($galleries as $category => $photos)
                        @foreach($photos as $photo)
                            <div class="col-6 col-lg-4 gallery-col" data-category="{{ $photo->category }}">
                                <a href="{{ Storage::url($photo->image_path) }}" class="glightbox d-block" data-gallery="gallery-all"
                                    data-description="{{ $photo->caption }}">
                                    <div class="gallery-item">
                                        <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->caption }}">
                                        <div class="gallery-overlay">
                                            <i class="bi bi-zoom-in text-white fs-3"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-images fs-1 mb-3 d-block"></i>
                    <p>Belum ada foto di galeri.</p>
                </div>
            @endif
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        // Init lightbox
        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
            closeButton: true,
        });


        // Filter
        const filterBtns = document.querySelectorAll('.filter-btn');
        const galleryCols = document.querySelectorAll('.gallery-col');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update tombol aktif
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'btn-primary');
                    b.classList.add('btn-outline-primary');
                });
                btn.classList.add('active', 'btn-primary');
                btn.classList.remove('btn-outline-primary');

                // Filter kolom
                const filter = btn.dataset.filter;
                galleryCols.forEach(col => {
                    if (filter === 'all' || col.dataset.category === filter) {
                        col.style.display = '';
                    } else {
                        col.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush