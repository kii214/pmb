<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — PMB STMIK ROSMA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            overflow: hidden;
        }
        .left-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            position: relative;
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #7c3aed 100%);
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 20% 20%, rgba(255,255,255,0.08) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 80%, rgba(124,58,237,0.3) 0%, transparent 60%);
        }
        .left-bg-circle { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.04); }
        .left-bg-circle.c1 { width: 400px; height: 400px; bottom: -100px; right: -100px; }
        .left-bg-circle.c2 { width: 200px; height: 200px; top: 60px; right: 80px; background: rgba(255,255,255,0.06); }
        .left-bg-circle.c3 { width: 120px; height: 120px; top: 200px; left: 40px; background: rgba(255,255,255,0.05); }
        .left-content { position: relative; z-index: 1; }
        .left-logo { display: flex; align-items: center; gap: 16px; margin-bottom: 60px; }
        .left-logo img { width: 52px; height: 52px; object-fit: contain; }
        .left-logo-text .brand { font-size: 1.1rem; font-weight: 800; color: #fff; letter-spacing: 0.5px; }
        .left-logo-text .sub { font-size: 0.72rem; color: rgba(255,255,255,0.6); letter-spacing: 2px; text-transform: uppercase; }
        .left-title { font-size: clamp(2rem, 3vw, 2.8rem); font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 20px; letter-spacing: -0.02em; }
        .left-title span { color: #fbbf24; }
        .left-desc { font-size: 1rem; color: rgba(255,255,255,0.65); line-height: 1.7; max-width: 380px; margin-bottom: 50px; }
        .left-stats { display: flex; gap: 32px; }
        .stat-num { font-size: 1.8rem; font-weight: 800; color: #fff; line-height: 1; margin-bottom: 4px; }
        .stat-lbl { font-size: 0.78rem; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 1px; }
        .stat-divider { width: 1px; background: rgba(255,255,255,0.15); }
        .right-panel {
            width: 480px;
            min-width: 480px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 52px;
        }
        .login-header { margin-bottom: 40px; }
        .login-header h2 { font-size: 1.9rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; margin-bottom: 8px; }
        .login-header p { color: #64748b; font-size: 0.95rem; }
        .form-group { margin-bottom: 22px; }
        .form-label { display: block; font-size: 0.85rem; font-weight: 700; color: #374151; margin-bottom: 8px; }
        .form-input-wrap { position: relative; }
        .form-input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1rem; pointer-events: none; }
        .form-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.95rem;
            color: #0f172a;
            background: #f8fafc;
            transition: all 0.2s ease;
            outline: none;
        }
        .form-input:focus { border-color: #2563eb; background: #fff; box-shadow: 0 0 0 4px rgba(37,99,235,0.08); }
        .form-input.is-error { border-color: #ef4444; }
        .form-error { font-size: 0.8rem; color: #ef4444; margin-top: 6px; }
        .form-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .remember-label { display: flex; align-items: center; gap: 8px; font-size: 0.875rem; color: #64748b; cursor: pointer; }
        .remember-label input { width: 16px; height: 16px; accent-color: #2563eb; cursor: pointer; }
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(37,99,235,0.35); }
        .btn-login:active { transform: translateY(0); }
        .back-link { text-align: center; margin-top: 28px; }
        .back-link a { font-size: 0.875rem; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s; }
        .back-link a:hover { color: #2563eb; }
        .session-alert { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 10px; padding: 12px 16px; font-size: 0.875rem; margin-bottom: 24px; }
        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; min-width: unset; min-height: 100vh; background: #fff; }
        }
    </style>
</head>
<body>
    <div class="left-panel">
        <div class="left-bg-circle c1"></div>
        <div class="left-bg-circle c2"></div>
        <div class="left-bg-circle c3"></div>
        <div class="left-content">
            <div class="left-logo">
                <img src="/images/logo-rosma.png" alt="STMIK ROSMA">
                <div class="left-logo-text">
                    <div class="brand">STMIK ROSMA</div>
                    <div class="sub">Portal Admin PMB</div>
                </div>
            </div>
            <h1 class="left-title">Kelola PMB<br><span>Lebih Mudah.</span></h1>
            <p class="left-desc">Dashboard terpadu untuk mengatur seluruh proses penerimaan mahasiswa baru STMIK ROSMA dari satu tempat.</p>
            <div class="left-stats">
                <div>
                    <div class="stat-num">4+</div>
                    <div class="stat-lbl">Program Studi</div>
                </div>
                <div class="stat-divider"></div>
                <div>
                    <div class="stat-num">3</div>
                    <div class="stat-lbl">Jalur Masuk</div>
                </div>
                <div class="stat-divider"></div>
                <div>
                    <div class="stat-num">2</div>
                    <div class="stat-lbl">Beasiswa</div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="login-header">
            <h2>Selamat Datang 👋</h2>
            <p>Masuk ke portal admin untuk mengelola PMB STMIK ROSMA.</p>
        </div>

        @if (session('status'))
            <div class="session-alert"><i class="bi bi-check-circle me-2"></i>{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <div class="form-input-wrap">
                    <i class="bi bi-envelope form-input-icon"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                        required autofocus autocomplete="username">
                </div>
                @error('email')
                    <div class="form-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="form-input-wrap">
                    <i class="bi bi-lock form-input-icon"></i>
                    <input id="password" type="password" name="password"
                        class="form-input {{ $errors->has('password') ? 'is-error' : '' }}"
                        required autocomplete="current-password">
                </div>
                @error('password')
                    <div class="form-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember_me"> Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:0.875rem;color:#2563eb;text-decoration:none;font-weight:600;">Lupa kata sandi?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Dashboard
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('home') }}"><i class="bi bi-arrow-left"></i> Kembali ke halaman utama</a>
        </div>
    </div>
</body>
</html>
