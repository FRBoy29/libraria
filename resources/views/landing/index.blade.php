@extends('layouts.landing')

@section('content')
<header class="navbar">
    <div class="container navbar-inner">
        <a class="brand" href="/" aria-label="LIBRARIA - beranda">
            <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA">
            <span class="brand-name">LIBRARIA</span>
        </a>
        <span class="brand-tagline">More Than Books. A Brighter Tomorrow.</span>
        <span class="navbar-spacer"></span>
        <a class="status-link" id="service-status" href="#layanan" data-open="true" aria-label="Status layanan perpustakaan">
            <span class="status-dot" aria-hidden="true"></span>
            <span class="status-text">Layanan Buka 08:00 – 17:00 WIB</span>
        </a>
        <button class="nav-btn" type="button" data-modal="help">Bantuan</button>
        <button class="nav-btn icon-btn" type="button" id="theme-toggle" aria-label="Alihkan mode terang dan gelap" aria-pressed="false" title="Alihkan tema">
            <span class="material-symbols-outlined" aria-hidden="true">dark_mode</span>
        </button>
        <div class="dropdown">
            <button class="nav-btn btn-primary" type="button" id="login-button" aria-haspopup="true" aria-expanded="false" aria-controls="login-menu">
                Masuk
                <span class="material-symbols-outlined" aria-hidden="true">expand_more</span>
            </button>
            <div class="dropdown-menu" id="login-menu" role="menu" hidden>
                <a class="dropdown-item" role="menuitem" href="/member/login">
                    <span class="material-symbols-outlined" aria-hidden="true">badge</span>
                    <span><strong>Masuk sebagai Member</strong><span>Pemustaka / Anggota</span></span>
                </a>
                <div class="dropdown-divider" aria-hidden="true"></div>
                <a class="dropdown-item" role="menuitem" href="/admin/login">
                    <span class="material-symbols-outlined" aria-hidden="true">admin_panel_settings</span>
                    <span><strong>Masuk sebagai Admin</strong><span>Petugas Perpustakaan / Staf</span></span>
                </a>
            </div>
        </div>
    </div>
</header>

<main>
    <section class="hero" aria-labelledby="hero-title">
        <div class="container">
            <img class="hero-logo" src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA">
            <h1 id="hero-title">Libraria</h1>
            <p class="hero-subtitle">Sistem Informasi Perpustakaan</p>
            <p class="hero-tagline">More Than Books. A Brighter Tomorrow.</p>
            <p class="hero-desc">Akses terpadu untuk pengelolaan perpustakaan dan layanan pemustaka.</p>
            <!-- MOCK DATA: replace with database data later -->
            <div class="stats" role="list" aria-label="Statistik layanan">
                <div class="stat" role="listitem">
                    <span class="material-symbols-outlined stat-icon" aria-hidden="true">auto_stories</span>
                    <span class="stat-text"><span class="stat-value">3.420+</span><span class="stat-label">Koleksi Judul</span></span>
                </div>
                <div class="stat" role="listitem">
                    <span class="material-symbols-outlined stat-icon" aria-hidden="true">groups</span>
                    <span class="stat-text"><span class="stat-value">1.280+</span><span class="stat-label">Pemustaka</span></span>
                </div>
                <div class="stat" role="listitem">
                    <span class="material-symbols-outlined stat-icon" aria-hidden="true">sync_alt</span>
                    <span class="stat-text"><span class="stat-value">Real-Time</span><span class="stat-label">Sirkulasi</span></span>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="layanan" aria-labelledby="layanan-title">
        <div class="container">
            <p class="section-kicker">Layanan Terpadu</p>
            <h2 class="section-title" id="layanan-title">Ekosistem Perpustakaan Modern</h2>
            <p class="section-desc">Tiga layanan inti yang menghubungkan petugas dan pemustaka dalam satu sistem terpadu.</p>
            <div class="feature-grid">
                <article class="feature-card">
                    <span class="feature-icon" aria-hidden="true"><span class="material-symbols-outlined">qr_code_scanner</span></span>
                    <h3>Manajemen Sirkulasi</h3>
                    <p>Pengelolaan peminjaman dan pengembalian buku dilakukan oleh petugas perpustakaan melalui sistem yang terintegrasi.</p>
                    <button class="feature-cta" type="button" data-modal="circulation">Pelajari Alur Sirkulasi <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></button>
                </article>
                <article class="feature-card">
                    <span class="feature-icon" aria-hidden="true"><span class="material-symbols-outlined">menu_book</span></span>
                    <h3>Koleksi Perpustakaan</h3>
                    <p>Informasi koleksi buku tersusun secara terpusat sehingga memudahkan pencarian dan pengelolaan perpustakaan.</p>
                    <button class="feature-cta" type="button" data-modal="collection">Lihat Koleksi <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></button>
                </article>
                <article class="feature-card">
                    <span class="feature-icon" aria-hidden="true"><span class="material-symbols-outlined">notifications_active</span></span>
                    <h3>Pengingat Jatuh Tempo</h3>
                    <p>Informasi status dan jatuh tempo peminjaman membantu petugas dan pemustaka memantau transaksi perpustakaan.</p>
                    <button class="feature-cta" type="button" data-modal="notification">Pelajari <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></button>
                </article>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container footer-inner">
        <p class="footer-brand"><strong>Libraria</strong> &bull; &copy; 2026 LIBRARIA — Sistem Informasi Manajemen Perpustakaan</p>
        <nav class="footer-links" aria-label="Tautan footer">
            <button class="link-btn" type="button" data-modal="help">Pusat Bantuan</button>
            <button class="link-btn" type="button" data-modal="privacy">Kebijakan Privasi</button>
        </nav>
    </div>
</footer>

<div class="modal-backdrop" id="modal-backdrop" hidden>
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="modal-header">
            <h2 id="modal-title"></h2>
            <button class="modal-close" type="button" id="modal-close" aria-label="Tutup dialog" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body" id="modal-body"></div>
        <div class="modal-footer">
            <button class="nav-btn btn-primary" type="button" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection
