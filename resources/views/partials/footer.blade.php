<footer class="footer mt-auto py-5" id="mainFooter">
    <div class="container">
        <div class="row g-4 justify-content-center text-center text-md-start">

            {{-- Kolom 1: Brand & Deskripsi --}}
            <div class="col-lg-5 col-md-12 col-12">
                <div class="d-flex align-items-center gap-2 mb-3 justify-content-center justify-content-md-start">
                    <img src="{{ asset('favicon.png') }}" alt="Logo" width="42" height="42" class="rounded-circle bg-white p-1">
                    <span class="fw-bold fs-5">{{ \App\Models\SiteSetting::get('site_name', 'Desa Wisata') }}</span>
                </div>
                <p class="text-muted small mb-4">
                    {{ \App\Models\SiteSetting::get('hero_subtitle', 'Jelajahi keindahan dan budaya desa kami') }}
                </p>
                <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                    @if(\App\Models\SiteSetting::get('social_instagram'))
                        <a href="{{ \App\Models\SiteSetting::get('social_instagram') }}" target="_blank" class="social-btn" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    @if(\App\Models\SiteSetting::get('social_facebook'))
                        <a href="{{ \App\Models\SiteSetting::get('social_facebook') }}" target="_blank" class="social-btn" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    @if(\App\Models\SiteSetting::get('social_youtube'))
                        <a href="{{ \App\Models\SiteSetting::get('social_youtube') }}" target="_blank" class="social-btn" aria-label="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    @endif
                    @if(\App\Models\SiteSetting::get('contact_phone'))
                        <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_phone') }}" target="_blank" class="social-btn" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Kolom 2: Navigasi --}}
            <div class="col-lg-3 col-md-6 col-12">
                <h6>Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('destinations.index') }}" class="text-muted text-decoration-none">Destinasi Wisata</a></li>
                    <li class="mb-2"><a href="{{ route('gallery') }}" class="text-muted text-decoration-none">Galeri</a></li>
                    @if(\App\Models\SiteSetting::get('feature_potential') == '1')
                        <li class="mb-2"><a href="{{ route('potential') }}" class="text-muted text-decoration-none">Peta Potensi</a></li>
                    @endif
                    @if(\App\Models\SiteSetting::get('feature_news') == '1')
                        <li class="mb-2"><a href="{{ route('news.index') }}" class="text-muted text-decoration-none">Berita</a></li>
                    @endif
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-muted text-decoration-none">Tentang Desa</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-muted text-decoration-none">Kontak</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Kontak --}}
            <div class="col-lg-4 col-md-6 col-12">
                <h6>Kontak</h6>
                <ul class="list-unstyled small text-muted footer-contact">
                    @if(\App\Models\SiteSetting::get('contact_phone'))
                        <li class="mb-2 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <i class="bi bi-whatsapp text-success"></i>
                            <span class="text-break">{{ \App\Models\SiteSetting::get('contact_phone') }}</span>
                        </li>
                    @endif
                    @if(\App\Models\SiteSetting::get('contact_email'))
                        <li class="mb-2 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <i class="bi bi-envelope" style="color: var(--primary)"></i>
                            <span class="text-break">{{ \App\Models\SiteSetting::get('contact_email') }}</span>
                        </li>
                    @endif
                    @if(\App\Models\SiteSetting::get('contact_address'))
                        <li class="mb-2 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <i class="bi bi-geo-alt" style="color: var(--primary)"></i>
                            <span class="text-break">{{ \App\Models\SiteSetting::get('contact_address') }}</span>
                        </li>
                    @endif
                </ul>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center small text-muted text-center text-md-start">
            <span>&copy; {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'Desa Wisata') }}. Semua hak dilindungi.</span>
            <span>Dibuat dengan <span class="text-green">❤</span> oleh Tim KKN 2026</span>
        </div>
    </div>
</footer>
