document.addEventListener('DOMContentLoaded', () => {
    // ===== DARK MODE =====
    const html = document.documentElement;
    const toggleBtn = document.getElementById('darkModeToggle');
    const toggleBtnMobile = document.getElementById('darkModeToggleMobile');
    const toggleIcon = document.getElementById('darkModeIcon');
    const toggleIconMobile = document.getElementById('darkModeIconMobile');
    const scrollTopBtn = document.getElementById('scrollTop');
    const navbar = document.getElementById('mainNavbar');

    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme, false);

    toggleBtn?.addEventListener('click', () => toggleTheme());
    toggleBtnMobile?.addEventListener('click', () => toggleTheme());

    function toggleTheme() {
        const current = html.getAttribute('data-bs-theme');
        const next = current === 'light' ? 'dark' : 'light';
        applyTheme(next, true);
        localStorage.setItem('theme', next);
    }

    function applyTheme(theme, animate = false) {
        html.setAttribute('data-bs-theme', theme);

        if (animate) {
            document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
        }

        if (theme === 'dark') {
            document.body.style.backgroundColor = '#0f0f0f';
            document.body.style.color = '#e5e5e5';
        } else {
            document.body.style.backgroundColor = '#ffffff';
            document.body.style.color = '#333333';
        }

        updateIcon(theme);
        updateNavbarState();

        // Broadcast to other tabs
        try {
            localStorage.setItem('theme', theme);
        } catch (e) {
            // ignore
        }
    }

    function updateIcon(theme) {
        const iconClass = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        if (toggleIcon) toggleIcon.className = iconClass;
        if (toggleIconMobile) toggleIconMobile.className = iconClass;
    }

    // Sync theme across tabs
    window.addEventListener('storage', (e) => {
        if (e.key === 'theme') {
            applyTheme(e.newValue || 'light', false);
        }
    });

    // ===== NAVBAR SCROLL EFFECT =====
    function updateNavbarState() {
        if (!navbar) return;

        const hero = document.querySelector('.hero-section');
        if (!hero) {
            navbar.classList.add('scrolled');
            return;
        }

        const heroBottom = hero.getBoundingClientRect().bottom;
        if (window.scrollY > 50 || heroBottom < 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', () => {
        updateNavbarState();

        if (scrollTopBtn) {
            if (window.scrollY > 300) {
                scrollTopBtn.style.display = 'flex';
            } else {
                scrollTopBtn.style.display = 'none';
            }
        }
    });

    scrollTopBtn?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Navbar mobile menu open state for solid background
    const navMenu = document.getElementById('navMenu');
    if (navMenu && navbar) {
        navMenu.addEventListener('show.bs.collapse', () => navbar.classList.add('menu-open'));
        navMenu.addEventListener('hide.bs.collapse', () => navbar.classList.remove('menu-open'));
    }

    // ===== HERO SCROLL INDICATOR =====
    document.querySelector('.hero-scroll')?.addEventListener('click', () => {
        const nextSection = document.querySelector('.hero-section')?.nextElementSibling;
        if (nextSection) {
            nextSection.scrollIntoView({ behavior: 'smooth' });
        }
    });

    // ===== GLIGHTBOX INIT =====
    if (typeof GLightbox !== 'undefined') {
        GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
        });
    }

    // Initial check
    updateNavbarState();
});
