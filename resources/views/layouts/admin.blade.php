<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — PMB STMIK ROSMA Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-rosma-admin.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --sidebar-w: 265px;
            --topbar-h: 64px;
            --primary: #4F46E5;
            --primary-dark: #3730A3;
            --sidebar-bg: #0c0f1d;
            --sidebar-hover: rgba(255,255,255,0.07);
            --sidebar-active: rgba(79,70,229,0.25);
            --sidebar-active-border: #4F46E5;
            --body-bg: #F1F5F9;
            --card-bg: #ffffff;
            --border: #E2E8F0;
            --text-main: #0F172A;
            --text-muted: #64748B;
        }

        * { box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-main);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* ============================
           SIDEBAR
           ============================ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            text-decoration: none;
            flex-shrink: 0;
        }
        .sidebar-brand .brand-logo {
            width: 34px; height: 34px;
            background: var(--primary);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .sidebar-brand .brand-text {
            display: flex; flex-direction: column;
        }
        .sidebar-brand .brand-name {
            font-weight: 800;
            color: white;
            font-size: 0.9rem;
            line-height: 1.2;
            letter-spacing: 0.3px;
        }
        .sidebar-brand .brand-sub {
            font-size: 0.65rem;
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
        }

        .nav-section-title {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.25);
            padding: 16px 8px 6px;
            margin-top: 4px;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 10px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.18s ease;
            margin-bottom: 2px;
            border-left: 3px solid transparent;
            position: relative;
        }
        .sidebar-item i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }
        .sidebar-item:hover {
            background: var(--sidebar-hover);
            color: rgba(255,255,255,0.9);
            border-left-color: rgba(79,70,229,0.4);
        }
        .sidebar-item.active {
            background: var(--sidebar-active);
            color: white;
            border-left-color: var(--sidebar-active-border);
            font-weight: 600;
        }
        .sidebar-item .badge-pill {
            margin-left: auto;
            background: rgba(79,70,229,0.3);
            color: #a5b4fc;
            font-size: 0.65rem;
            padding: 2px 7px;
            border-radius: 20px;
            font-weight: 700;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,0.06);
            margin: 10px 8px;
        }

        .sidebar-logout {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-logout form button {
            display: flex;
            align-items: center;
            gap: 11px;
            width: 100%;
            padding: 9px 10px;
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.4);
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.18s;
            text-align: left;
        }
        .sidebar-logout form button:hover {
            background: rgba(239,68,68,0.12);
            color: #f87171;
        }

        /* ============================
           MAIN WRAPPER
           ============================ */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            height: var(--topbar-h);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
            gap: 16px;
        }
        .topbar-title {
            font-weight: 700;
            color: var(--text-main);
            font-size: 1rem;
            margin: 0;
        }
        .topbar-breadcrumb {
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }
        .topbar-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid var(--border);
            background: white;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.15s;
        }
        .topbar-btn:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            color: var(--text-main);
        }
        .topbar-btn.primary {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        .topbar-btn.primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
        }

        /* CONTENT AREA */
        .content-area {
            padding: 28px;
            flex: 1;
        }

        /* ============================
           CARDS
           ============================ */
        .admin-card {
            background: var(--card-bg);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.03);
            overflow: hidden;
        }
        .admin-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
        }
        .admin-card-title {
            margin: 0;
            font-weight: 700;
            color: var(--text-main);
            font-size: 0.95rem;
        }
        .admin-card-body { padding: 22px; }

        /* TABLE */
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .admin-table thead tr th {
            padding: 11px 16px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            background: #F8FAFC;
            border-bottom: 1px solid var(--border);
        }
        .admin-table tbody tr td {
            padding: 14px 16px;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.875rem;
            color: #334155;
            vertical-align: middle;
        }
        .admin-table tbody tr:last-child td { border-bottom: none; }
        .admin-table tbody tr:hover td { background: #FAFBFD; }

        /* STATUS BADGES */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .status-badge.green { background: #DCFCE7; color: #166534; }
        .status-badge.yellow { background: #FEF9C3; color: #854D0E; }
        .status-badge.blue { background: #DBEAFE; color: #1E40AF; }
        .status-badge.red { background: #FEE2E2; color: #991B1B; }
        .status-badge.gray { background: #F1F5F9; color: #475569; }

        /* ALERTS */
        .alert-success-custom {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #166534;
            padding: 14px 18px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* MOBILE */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand" style="padding: 0 16px;">
            <img src="{{ asset('images/logo-rosma-admin.png') }}" alt="STMIK ROSMA"
                 style="height: 42px; width: 42px; object-fit: contain; border-radius: 8px; flex-shrink:0; background:white; padding:3px;">
            <div class="brand-text">
                <span class="brand-name" style="font-size:0.85rem;">STMIK ROSMA</span>
                <span class="brand-sub">Portal Admin PMB</span>
            </div>
        </a>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-squares"></i>
                <span>Dashboard</span>
            </a>

            <div class="nav-section-title">Pendaftaran</div>
            <a href="{{ route('admin.applicants.index') }}" class="sidebar-item {{ request()->routeIs('admin.applicants.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Kelola Pendaftar</span>
            </a>

            <div class="nav-section-title">Master Data</div>
            <a href="{{ route('admin.programs') }}" class="sidebar-item {{ request()->routeIs('admin.programs') ? 'active' : '' }}">
                <i class="bi bi-mortarboard"></i>
                <span>Program Studi</span>
            </a>
            <a href="{{ route('admin.fees') }}" class="sidebar-item {{ request()->routeIs('admin.fees') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Biaya & Jalur</span>
            </a>
            <a href="{{ route('admin.steps') }}" class="sidebar-item {{ request()->routeIs('admin.steps') ? 'active' : '' }}">
                <i class="bi bi-list-ol"></i>
                <span>Alur Pendaftaran</span>
            </a>

            <div class="nav-section-title">Konten Website</div>
            <a href="{{ route('admin.banners.index') }}" class="sidebar-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i>
                <span>Banners Carousel</span>
            </a>
            <a href="{{ route('admin.news') }}" class="sidebar-item {{ request()->routeIs('admin.news') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i>
                <span>Berita & Kegiatan</span>
            </a>
            <a href="{{ route('admin.partners.index') }}" class="sidebar-item {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Logo Mitra</span>
            </a>
            <a href="{{ route('admin.faq') }}" class="sidebar-item {{ request()->routeIs('admin.faq') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i>
                <span>FAQ</span>
            </a>

            <div class="sidebar-divider"></div>

            <div class="nav-section-title">Sistem</div>
            <a href="{{ route('admin.settings') }}" class="sidebar-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
        </nav>

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-left" style="font-size:1rem;width:20px;text-align:center;"></i>
                    Keluar / Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="main-wrapper">
        <header class="topbar">
            <button class="btn btn-sm btn-light d-lg-none me-2 border" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div>
                <p class="topbar-title mb-0">@yield('title', 'Dashboard')</p>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('home') }}" target="_blank" class="topbar-btn">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span class="d-none d-md-inline">Lihat Website</span>
                </a>
                <div class="dropdown">
                    <div class="user-avatar dropdown-toggle" data-bs-toggle="dropdown" style="list-style:none;">
                        {{ substr(Auth::user()?->name ?? 'A', 0, 1) }}
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" style="min-width:200px;">
                        <li class="px-3 py-2 border-bottom">
                            <p class="mb-0 fw-semibold text-dark small">{{ Auth::user()?->name ?? 'Administrator' }}</p>
                            <p class="mb-0 text-muted" style="font-size:0.75rem;">{{ Auth::user()?->email ?? 'admin@rosma.ac.id' }}</p>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2 fw-semibold small">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="content-area">
            @if(session('success'))
                <div class="alert-success-custom mb-4">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-sm ms-auto" onclick="this.parentElement.remove()"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
