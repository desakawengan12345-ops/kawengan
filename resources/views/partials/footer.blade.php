<footer class="footer mt-auto py-5" id="mainFooter">
    <div class="container">
        <div class="row g-4">

            {{-- Kolom 1: Info Desa --}}
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset('favicon.png') }}" alt="Logo" width="40" height="40" class="rounded-circle bg-white p-1">
                    <span class="fw-bold fs-5">{{ \App\Models\SiteSetting::get('site_name', 'Desa Wisata') }}</span>
                </div>
                <p class="text-muted small mb-4">
                    {{ \App\Models\SiteSetting::get('hero_subtitle', 'Jelajahi keindahan dan budaya desa kami') }}
                </p>
                <div class="d-flex gap-2">
                    @if(\App\Models\SiteSetting::get('social_instagram'))
                        <a href="{{ \App\Models\SiteSetting::get('social_instagram') }}" target="_blank"
                            class="social-btn">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    @if(\App\Models\SiteSetting::get('social_facebook'))
                        <a href="{{ \App\Models\SiteSetting::get('social_facebook') }}" target="_blank"
                            class="social-btn">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    @if(\App\Models\SiteSetting::get('social_youtube'))
                        <a href="{{ \App\Models\SiteSetting::get('social_youtube') }}" target="_blank"
                            class="social-btn">
                            <i class="bi bi-youtube"></i>
                        </a>
                    @endif
                    @if(\App\Models\SiteSetting::get('contact_phone'))
                        <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_phone') }}" target="_blank"
                            class="social-btn">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Kolom 2: Navigasi --}}
            <div class="col-lg-2 col-6">
                <h6>Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a>
                    </li>
                    <li class="mb-2"><a href="{{ route('destinations.index') }}"
                            class="text-muted text-decoration-none">Destinasi Wisata</a></li>
                    <li class="mb-2"><a href="{{ route('gallery') }}" class="text-muted text-decoration-none">Galeri</a>
                    </li>
                    @if(\App\Models\SiteSetting::get('feature_potential') == '1')
                        <li class="mb-2"><a href="{{ route('potential') }}" class="text-muted text-decoration-none">Peta
                                Potensi</a></li>
                    @endif
                    @if(\App\Models\SiteSetting::get('feature_news') == '1')
                        <li class="mb-2"><a href="{{ route('news.index') }}"
                                class="text-muted text-decoration-none">Berita</a></li>
                    @endif
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-muted text-decoration-none">Tentang
                            Desa</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-muted text-decoration-none">Kontak</a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Kontak --}}
            <div class="col-lg-3 col-6">
                <h6>Kontak</h6>
                <ul class="list-unstyled small text-muted">
                    @if(\App\Models\SiteSetting::get('contact_phone'))
                        <li class="mb-2">
                            <i class="bi bi-whatsapp me-2 text-green"></i>
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

            {{-- Kolom 4: Jam Operasional / Info Tambahan --}}
            <div class="col-lg-3">
                <h6>Jam Operasional</h6>
                <p class="small text-muted mb-2">Setiap hari, 08.00 - 17.00 WIB</p>
                <p class="small text-muted mb-0">Kunjungi kami dan rasakan pengalaman wisata desa yang autentik.</p>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted">
            <span>&copy; {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'Desa Wisata') }}. Semua hak dilindungi.</span>
            <span>Dibuat dengan <span class="text-green">❤</span> oleh Tim KKN 2026</span>
        </div>
    </div>
</footer>
