<footer class="footer mt-auto py-5" id="mainFooter">
    <div class="container">
        <div class="row g-4">

            {{-- Kolom 1: Info Desa --}}
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset('favicon.png') }}" alt="Logo" width="32" height="32">
                    <span class="fw-bold fs-5">Desa Kawengan</span>
                </div>
                <p class="text-muted small">
                    {{ \App\Models\SiteSetting::get('hero_subtitle', 'Jelajahi keindahan dan budaya desa kami') }}
                </p>
            </div>

            {{-- Kolom 2: Navigasi --}}
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('destinations.index') }}" class="text-muted text-decoration-none">Destinasi Wisata</a></li>
                    <li class="mb-2"><a href="{{ route('gallery') }}" class="text-muted text-decoration-none">Galeri</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-muted text-decoration-none">Tentang Desa</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-muted text-decoration-none">Kontak</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Kontak --}}
            <div class="col-lg-3 col-6">
                <h6 class="fw-bold mb-3">Kontak</h6>
                <ul class="list-unstyled small text-muted">
                    @if(\App\Models\SiteSetting::get('contact_phone'))
                    <li class="mb-2">
                        <i class="bi bi-whatsapp me-2 text-success"></i>
                        {{ \App\Models\SiteSetting::get('contact_phone') }}
                    </li>
                    @endif
                    @if(\App\Models\SiteSetting::get('contact_email'))
                    <li class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        {{ \App\Models\SiteSetting::get('contact_email') }}
                    </li>
                    @endif
                    @if(\App\Models\SiteSetting::get('contact_address'))
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        {{ \App\Models\SiteSetting::get('contact_address') }}
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Kolom 4: Media Sosial --}}
            <div class="col-lg-3">
                <h6 class="fw-bold mb-3">Ikuti Kami</h6>
                <div class="d-flex gap-2">
                    @if(\App\Models\SiteSetting::get('social_instagram'))
                    <a href="{{ \App\Models\SiteSetting::get('social_instagram') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-instagram"></i>
                    </a>
                    @endif
                    @if(\App\Models\SiteSetting::get('social_facebook'))
                    <a href="{{ \App\Models\SiteSetting::get('social_facebook') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-facebook"></i>
                    </a>
                    @endif
                </div>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted">
            <span>&copy; {{ date('Y') }} Desa Wisata Kawengan. Semua hak dilindungi.</span>
            <span>Dibuat dengan ❤️ oleh Tim KKN 2026</span>
        </div>
    </div>
</footer>