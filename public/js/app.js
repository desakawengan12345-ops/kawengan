document.addEventListener('DOMContentLoaded', () => {
    // ===== DARK MODE =====
    const html = document.documentElement;
    const toggleBtn = document.getElementById('darkModeToggle');
    const toggleIcon = document.getElementById('darkModeIcon');
    const scrollTopBtn = document.getElementById('scrollTop');

    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    toggleBtn?.addEventListener('click', () => {
        const current = html.getAttribute('data-bs-theme');
        const next = current === 'light' ? 'dark' : 'light';
        applyTheme(next);
        localStorage.setItem('theme', next);
    });

    function applyTheme(theme) {
        html.setAttribute('data-bs-theme', theme);
        updateIcon(theme);

        const navbar = document.getElementById('mainNavbar');

        if (theme === 'dark') {
            document.body.style.backgroundColor = '#0f0f1a';
            document.body.style.color = '#e0e0e0';
            if (navbar) navbar.style.borderBottom = 'none';
        } else {
            document.body.style.backgroundColor = '#ffffff';
            document.body.style.color = '#212529';
            if (navbar) navbar.style.borderBottom = '1px solid #e5e7eb';
        }
    }

    function updateIcon(theme) {
        toggleIcon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
    }

    // ===== SCROLL TO TOP =====
    window.addEventListener('scroll', () => {
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

    // ===== NAVBAR SCROLL EFFECT =====
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('mainNavbar');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
            } else {
                navbar.style.boxShadow = 'none';
            }
        }
    });
});
