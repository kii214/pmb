<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Portal Penerimaan Mahasiswa Baru STMIK ROSMA - Kampus Teknologi Terkemuka di Karawang">
        <meta name="theme-color" content="#2563EB">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo-rosma.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('images/logo-rosma.png') }}">
        <title>@yield('title', config('app.name'))</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- AOS Animation CSS -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body>
        @php
            $setting = \App\Models\ContactSetting::first();
        @endphp


        <header class="site-header" id="siteHeader">
            <div class="header-top-accent"></div>
            <nav class="navbar navbar-expand-xl py-2">
                <div class="container-fluid px-3 px-md-4 px-xl-4 px-xxl-5" style="max-width: 1480px;">
                    <a class="navbar-brand d-flex align-items-center gap-2 gap-sm-3 flex-shrink-0" href="{{ route('home') }}">
                        <img src="{{ asset('images/logo-rosma.png') }}" alt="Logo STMIK ROSMA" class="nav-logo">
                        <div class="lh-sm">
                            <div class="brand-name mb-0 text-nowrap">STMIK ROSMA</div>
                            <small class="brand-sub text-nowrap">PENERIMAAN MAHASISWA BARU</small>
                        </div>
                    </a>
                    <button class="navbar-toggler border-0 p-2 shadow-none rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="mainNav">
                        <ul class="navbar-nav mx-auto gap-xl-1 gap-xxl-2 my-3 my-xl-0">
                            <li class="nav-item">
                                <a class="nav-link px-2 px-xxl-3 rounded-pill transition-all" href="{{ route('home') }}">
                                    <i class="bi bi-house-door d-xl-none me-2 text-primary"></i>Beranda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-xxl-3 rounded-pill transition-all" href="{{ route('home') }}#jalur">
                                    <i class="bi bi-signpost-2 d-xl-none me-2 text-primary"></i>Jalur Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-xxl-3 rounded-pill transition-all" href="{{ route('programs.index') }}">
                                    <i class="bi bi-mortarboard d-xl-none me-2 text-primary"></i>Program Studi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-xxl-3 rounded-pill transition-all" href="{{ route('fees.index') }}">
                                    <i class="bi bi-wallet2 d-xl-none me-2 text-primary"></i>Biaya Kuliah
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-xxl-3 rounded-pill transition-all {{ request()->routeIs('applications.status') ? 'active' : '' }}" href="{{ route('applications.status') }}">
                                    <i class="bi bi-search d-xl-none me-2 text-primary"></i>Cek Status
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle px-2 px-xxl-3 rounded-pill transition-all" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-info-circle d-xl-none me-2 text-primary"></i>Informasi
                                </a>
                                <ul class="dropdown-menu border-0 shadow-lg mt-2 rounded-4 p-2">
                                    <li><a class="dropdown-item rounded-3 py-2 fw-semibold" href="{{ route('home') }}#informasi"><i class="bi bi-bank2 me-2 text-primary"></i>Tentang PMB</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2 fw-semibold" href="{{ route('home') }}#keunggulan"><i class="bi bi-stars me-2 text-primary"></i>Pilar Keunggulan</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2 fw-semibold" href="{{ route('home') }}#tahapan"><i class="bi bi-list-ol me-2 text-primary"></i>Alur Pendaftaran</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2 fw-semibold" href="{{ route('home') }}#berita"><i class="bi bi-newspaper me-2 text-primary"></i>Berita & Pengumuman</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2 fw-semibold" href="{{ route('home') }}#faq"><i class="bi bi-question-circle me-2 text-primary"></i>Bantuan (FAQ)</a></li>
                                </ul>
                            </li>
                        </ul>
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="btn-nav-register text-nowrap" style="background:#0f2c59; border-color:#0f2c59;">
                                        <i class="bi bi-speedometer2 me-1"></i> Panel Admin
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 ms-1 fw-bold">Logout</button>
                                    </form>
                                @else
                                    <a href="{{ route('dashboard') }}" class="btn-nav-register text-nowrap"><i class="bi bi-person-circle me-1"></i> Dashboard Saya</a>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3 ms-1">Logout</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-nav-login text-nowrap"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
                                <a href="{{ route('applications.create') }}" class="btn-nav-register text-nowrap"><i class="bi bi-pencil-square me-1"></i> Daftar Sekarang</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-5 pe-lg-5">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <img src="{{ asset('images/logo-rosma.png') }}" alt="Logo STMIK ROSMA" style="width:60px;height:60px;object-fit:contain;">
                                <div class="lh-sm">
                                    <div class="footer-brand-name">STMIK ROSMA</div>
                                    <small class="footer-brand-sub">PENERIMAAN MAHASISWA BARU</small>
                                </div>
                            </div>
                            <p class="footer-desc">
                                Sistem Penerimaan Mahasiswa Baru STMIK ROSMA. Kami berkomitmen mencetak generasi digital yang inovatif dan siap bersaing di era teknologi modern.
                            </p>
                            <div class="d-flex gap-2 mt-4">
                                <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="footer-social"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="footer-social"><i class="bi bi-youtube"></i></a>
                                <a href="#" class="footer-social"><i class="bi bi-tiktok"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <h6 class="footer-heading">Tautan Penting</h6>
                            <ul class="footer-links">
                                <li><a href="{{ route('programs.index') }}"><i class="bi bi-chevron-right"></i> Program Studi</a></li>
                                <li><a href="{{ route('fees.index') }}"><i class="bi bi-chevron-right"></i> Informasi Biaya</a></li>
                                <li><a href="{{ route('home') }}#jalur"><i class="bi bi-chevron-right"></i> Jalur Penerimaan</a></li>
                                <li><a href="{{ route('home') }}#tahapan"><i class="bi bi-chevron-right"></i> Alur Pendaftaran</a></li>
                                <li><a href="{{ route('home') }}#faq"><i class="bi bi-chevron-right"></i> Pusat Bantuan</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <h6 class="footer-heading">Hubungi Kami</h6>
                            <ul class="footer-contact">
                                <li>
                                    <i class="bi bi-building"></i>
                                    <span>{{ $setting?->campus_name ?? 'STMIK ROSMA' }}<br>{{ $setting?->address ?? 'Jl. Parahiyangan, Adiarsa Bar., Kec. Karawang Bar., Karawang, Jawa Barat 41311' }}</span>
                                </li>
                                <li>
                                    <i class="bi bi-whatsapp"></i>
                                    <span>{{ $setting?->whatsapp_number ?? '081234567890' }}<br><small>(Hanya Chat WhatsApp)</small></span>
                                </li>
                                <li>
                                    <i class="bi bi-envelope"></i>
                                    <span>pmb@rosma.ac.id</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container text-center">
                    <span>&copy; {{ now()->year }} STMIK ROSMA &mdash; Sekolah Tinggi Manajemen Informatika dan Komputer. Hak Cipta Dilindungi.</span>
                </div>
            </div>
        </footer>

        @php
            $waSetting = \App\Models\ContactSetting::first();
            $waNumber = preg_replace('/[^0-9]/', '', $waSetting?->whatsapp_number ?? '6281234567890');
            $waMessage = urlencode($waSetting?->whatsapp_message ?? 'Halo Admin PMB STMIK ROSMA, saya ingin bertanya.');
        @endphp
        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Chat dengan Admin PMB" style="padding: 1rem; justify-content: center; width: 60px; height: 60px;">
            <i class="bi bi-whatsapp" style="margin: 0;"></i>
        </a>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- AOS Animation JS -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ duration: 900, once: true, offset: 80, easing: 'ease-out-cubic' });

            // Sticky header scroll effect
            const header = document.getElementById('siteHeader');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            // Animated counter
            function animateCounter(el) {
                const target = parseInt(el.getAttribute('data-target'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) { current = target; clearInterval(timer); }
                    el.textContent = Math.floor(current).toLocaleString('id-ID');
                }, 16);
            }
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(e => { if (e.isIntersecting) { animateCounter(e.target); counterObserver.unobserve(e.target); } });
            }, { threshold: 0.5 });
            document.querySelectorAll('[data-target]').forEach(el => counterObserver.observe(el));
        </script>
        @stack('scripts')
        <script>
            // Unregister obsolete service workers and purge caches
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.getRegistrations().then(function(registrations) {
                    for (let registration of registrations) {
                        registration.unregister();
                    }
                });
            }
            if ('caches' in window) {
                caches.keys().then(function(names) {
                    for (let name of names) {
                        caches.delete(name);
                    }
                });
            }
        </script>
    </body>
</html>
