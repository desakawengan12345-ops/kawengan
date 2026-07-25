<nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
    <div class="container">

        {{-- Logo Kiri --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('favicon.png') }}" alt="Logo" width="40" height="40">
            <div>
                <div class="fw-bold lh-1">{{ \App\Models\SiteSetting::get('site_name', 'Desa Wisata') }}</div>
                <div class="opacity-75" style="font-size:0.7rem">Desa Wisata</div>
            </div>
        </a>

        {{-- Toggle Mobile --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu Tengah + Tombol Kanan --}}
        <div class="collapse navbar-collapse" id="navMenu">

            {{-- Menu --}}
            <ul class="navbar-nav mx-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('destinations*') ? 'active' : '' }}"
                        href="{{ route('destinations.index') }}">Destinasi Wisata</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}"
                        href="{{ route('gallery') }}">Galeri</a>
                </li>
                @if(\App\Models\SiteSetting::get('feature_potential') == '1')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('potential') ? 'active' : '' }}"
                            href="{{ route('potential') }}">Peta Potensi</a>
                    </li>
                @endif
                @if(\App\Models\SiteSetting::get('feature_news') == '1')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news*') ? 'active' : '' }}"
                            href="{{ route('news.index') }}">Berita</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">Tentang Desa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Kontak</a>
                </li>
            </ul>

            {{-- Tombol Kanan --}}
            <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
                @if(\App\Models\SiteSetting::get('contact_phone'))
                    <a href="https://wa.me/{{ \App\Models\SiteSetting::get('contact_phone') }}" target="_blank"
                        class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-whatsapp me-1"></i>Hubungi Kami
                    </a>
                @endif
                <button id="darkModeToggle" title="Ganti tema">
                    <i class="bi bi-moon-fill" id="darkModeIcon"></i>
                </button>
            </div>

        </div>
    </div>
</nav>