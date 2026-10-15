/* LIBRARIA landing interactions. Source of truth: resources/js/landing.js (copied to public/js). */
(function () {
    'use strict';

    var THEME_KEY = 'libraria-theme';
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- Theme toggle ---------- */
    var themeToggle = document.getElementById('theme-toggle');

    function currentTheme() {
        return document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    }

    function renderThemeIcon() {
        if (!themeToggle) return;
        var icon = themeToggle.querySelector('.material-symbols-outlined');
        if (icon) icon.textContent = currentTheme() === 'dark' ? 'light_mode' : 'dark_mode';
        themeToggle.setAttribute('aria-pressed', currentTheme() === 'dark' ? 'true' : 'false');
    }

    function setTheme(theme) {
        var isDark = theme === 'dark';
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', isDark);
        try {
            localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
        } catch (e) { /* storage unavailable: theme still applies for session */ }
        renderThemeIcon();
    }

    if (themeToggle) {
        renderThemeIcon();
        themeToggle.addEventListener('click', function () {
            setTheme(currentTheme() === 'dark' ? 'light' : 'dark');
        });
        themeToggle.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                setTheme(currentTheme() === 'dark' ? 'light' : 'dark');
            }
        });
    }

    window.addEventListener('storage', function (e) {
        if (e.key === THEME_KEY) {
            var isDark = e.newValue === 'dark';
            document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', isDark);
            renderThemeIcon();
        }
    });

    /* ---------- Service status follows device clock ---------- */
    var statusLink = document.getElementById('service-status');

    function updateServiceStatus(now) {
        if (!statusLink) return;
        var time = now instanceof Date ? now : new Date();
        var mins = time.getHours() * 60 + time.getMinutes();
        var open = mins >= 480 && mins < 1020; // 08:00–17:00 device time
        statusLink.setAttribute('data-open', open ? 'true' : 'false');
        var label = statusLink.querySelector('.status-text');
        if (label) {
            label.textContent = open
                ? 'Layanan Buka 08:00 \u2013 17:00 WIB'
                : 'Layanan Tutup \u2022 Buka 08:00 \u2013 17:00 WIB';
        }
        statusLink.setAttribute('aria-label', open ? 'Layanan buka' : 'Layanan tutup');
    }

    updateServiceStatus();
    window.setInterval(updateServiceStatus, 60000);

    /* ---------- Login dropdown ---------- */
    var loginBtn = document.getElementById('login-button');
    var loginMenu = document.getElementById('login-menu');

    function isMenuOpen(menuEl) {
        return !!menuEl && menuEl.hidden === false;
    }

    function openMenu(btn, menu) {
        if (!btn || !menu) return;
        menu.hidden = false;
        btn.setAttribute('aria-expanded', 'true');
    }

    function closeMenu(btn, menu) {
        if (!btn || !menu) return;
        menu.hidden = true;
        btn.setAttribute('aria-expanded', 'false');
    }

    function setupLoginDropdown(btn, menu) {
        if (!btn || !menu) return;
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (isMenuOpen(menu)) closeMenu(btn, menu);
            else openMenu(btn, menu);
        });
        document.addEventListener('click', function (e) {
            if (isMenuOpen(menu) && !menu.contains(e.target) && e.target !== btn && !btn.contains(e.target)) {
                closeMenu(btn, menu);
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isMenuOpen(menu)) {
                closeMenu(btn, menu);
                btn.focus();
            }
        });
    }

    setupLoginDropdown(loginBtn, loginMenu);

    /* ---------- Reusable modal ---------- */
    var MODAL_CONTENT = {
        help: {
            title: 'Pusat Bantuan',
            body: '<h3>Member</h3><p>Gunakan akun yang diberikan oleh perpustakaan.</p>' +
                '<h3>Admin</h3><p>Gunakan akun admin yang telah terdaftar.</p>' +
                '<h3>Peminjaman dan pengembalian</h3><p>Diproses oleh Admin/Petugas.</p>'
        },
        privacy: {
            title: 'Kebijakan Privasi',
            body: '<p>LIBRARIA menyimpan data akun dan transaksi perpustakaan hanya untuk keperluan layanan sirkulasi dan pengelolaan koleksi. Data tidak dibagikan ke pihak ketiga. Hubungi petugas perpustakaan untuk permintaan pembaruan atau penghapusan data pribadi.</p>'
        },
        circulation: {
            title: 'Alur Sirkulasi',
            body: '<p>Pengelolaan peminjaman dan pengembalian buku dilakukan oleh petugas perpustakaan melalui sistem yang terintegrasi:</p>' +
                '<p>1. Anggota datang ke perpustakaan dengan Member ID.<br>2. Petugas mencatat peminjaman dan memeriksa stok.<br>3. Pengembalian diproses petugas; stok bertambah dan status diperbarui otomatis.</p>'
        },
        collection: {
            title: 'Koleksi Perpustakaan',
            body: '<p>Informasi koleksi buku tersusun secara terpusat sehingga memudahkan pencarian dan pengelolaan perpustakaan. Anggota dapat menelusuri katalog setelah masuk sebagai Member. Penambahan, pengubahan, dan penghapusan koleksi dilakukan oleh petugas.</p>'
        },
        notification: {
            title: 'Pengingat Jatuh Tempo',
            body: '<p>Informasi status dan jatuh tempo peminjaman membantu petugas dan pemustaka memantau transaksi perpustakaan. Anggota melihat status Active, Overdue, dan Returned pada halaman Peminjaman Saya dan Riwayat.</p>'
        }
    };

    var backdrop = document.getElementById('modal-backdrop');
    var modalTitle = document.getElementById('modal-title');
    var modalBody = document.getElementById('modal-body');
    var lastFocused = null;

    function openModal(type) {
        var content = MODAL_CONTENT[type];
        if (!content || !backdrop) return;
        lastFocused = document.activeElement;
        modalTitle.textContent = content.title;
        modalBody.innerHTML = content.body;
        backdrop.hidden = false;
        document.body.style.overflow = 'hidden';
        var closeBtn = document.getElementById('modal-close');
        if (closeBtn) closeBtn.focus();
    }

    function closeModal() {
        if (!backdrop || backdrop.hidden) return;
        backdrop.hidden = true;
        document.body.style.overflow = '';
        if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
    }

    window.openModal = openModal;
    window.closeModal = closeModal;

    document.addEventListener('click', function (e) {
        var opener = e.target.closest ? e.target.closest('[data-modal]') : null;
        if (opener) {
            openModal(opener.getAttribute('data-modal'));
            return;
        }
        if (e.target === backdrop) closeModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && backdrop && !backdrop.hidden) closeModal();
    });

    /* Smooth anchor scrolling (skip when reduced motion preferred) */
    if (!reduceMotion) {
        document.addEventListener('click', function (e) {
            var anchor = e.target.closest ? e.target.closest('a[href^="#"]') : null;
            if (!anchor) return;
            var target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
})();
