<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran PMB STMIK ROSMA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #f1f5f9; font-family: 'Segoe UI', Arial, sans-serif; color: #1e293b; }
        .wrapper { max-width: 620px; margin: 0 auto; padding: 32px 16px; }

        /* Header */
        .header {
            background: linear-gradient(135deg, #0f2c59 0%, #1e4fa0 100%);
            border-radius: 16px 16px 0 0;
            padding: 36px 40px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            top: -80px; right: -60px;
        }
        .header::after {
            content: '';
            position: absolute;
            width: 150px; height: 150px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            bottom: -50px; left: -30px;
        }
        .header-logo { display: inline-block; position: relative; z-index: 2; }
        .header-logo-inner {
            background: rgba(255,255,255,0.12);
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 16px;
            padding: 12px 24px;
            display: inline-block;
            margin-bottom: 16px;
        }
        .header-logo-inner span {
            color: #facc15;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .header h1 {
            color: #ffffff;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
            position: relative; z-index: 2;
        }
        .header p {
            color: rgba(255,255,255,0.65);
            font-size: 13px;
            position: relative; z-index: 2;
        }

        /* Success Banner */
        .success-banner {
            background: #ecfdf5;
            border-top: 4px solid #22c55e;
            padding: 20px 40px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .success-icon {
            width: 48px; height: 48px;
            background: #22c55e;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .success-banner h2 { font-size: 16px; font-weight: 700; color: #166534; margin-bottom: 3px; }
        .success-banner p { font-size: 13px; color: #4ade80; }

        /* Body */
        .body {
            background: #ffffff;
            padding: 36px 40px;
        }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 12px; line-height: 1.6; }
        .greeting strong { color: #0f2c59; }

        /* Registration Number Box */
        .reg-box {
            background: linear-gradient(135deg, #0f2c59, #1e4fa0);
            border-radius: 14px;
            padding: 24px 28px;
            text-align: center;
            margin: 24px 0;
            position: relative;
            overflow: hidden;
        }
        .reg-box::before {
            content: '';
            position: absolute;
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            top: -50px; right: -40px;
        }
        .reg-box .reg-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.55);
            margin-bottom: 8px;
        }
        .reg-box .reg-number {
            font-size: 26px;
            font-weight: 900;
            font-family: 'Courier New', monospace;
            letter-spacing: 3px;
            color: #facc15;
            margin-bottom: 8px;
        }
        .reg-box .reg-note {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
        }

        /* Info Table */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            margin: 28px 0 14px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f1f5f9;
        }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table tr { border-bottom: 1px solid #f8fafc; }
        .info-table td {
            padding: 11px 0;
            font-size: 14px;
            vertical-align: top;
        }
        .info-table td:first-child {
            color: #64748b;
            width: 42%;
            font-weight: 500;
        }
        .info-table td:last-child {
            color: #1e293b;
            font-weight: 700;
            text-align: right;
        }
        .badge-prodi {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-prodi.alt { background: #f5f3ff; color: #6d28d9; }
        .badge-status {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Steps */
        .steps { display: table; width: 100%; margin: 24px 0; border-spacing: 8px; }
        .step { display: table-cell; text-align: center; vertical-align: top; }
        .step-num {
            width: 36px; height: 36px;
            background: #0f2c59;
            color: white;
            border-radius: 50%;
            font-size: 14px;
            font-weight: 800;
            line-height: 36px;
            margin: 0 auto 8px;
        }
        .step-num.done { background: #22c55e; }
        .step-num.active { background: #f59e0b; }
        .step-title { font-size: 11px; font-weight: 700; color: #334155; }
        .step-sub { font-size: 10px; color: #94a3b8; margin-top: 2px; }

        /* CTA Button */
        .cta-wrap { text-align: center; margin: 30px 0; }
        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, #0f2c59, #1e4fa0);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            padding: 14px 40px;
            border-radius: 50px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 20px rgba(15,44,89,0.35);
        }
        .cta-btn-secondary {
            display: inline-block;
            background: #f8fafc;
            border: 2px solid #cbd5e1;
            color: #334155 !important;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 28px;
            border-radius: 50px;
            margin-top: 12px;
        }

        /* Notice Box */
        .notice-box {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-left: 4px solid #f59e0b;
            border-radius: 10px;
            padding: 16px 20px;
            margin: 24px 0;
        }
        .notice-box p { font-size: 13px; color: #78350f; line-height: 1.6; }
        .notice-box strong { color: #92400e; }

        /* Credentials */
        .cred-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px 20px;
            margin: 16px 0;
        }
        .cred-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; font-size: 13px; }
        .cred-label { color: #64748b; font-weight: 500; }
        .cred-value { color: #1e293b; font-weight: 700; font-family: 'Courier New', monospace; background: white; padding: 3px 10px; border-radius: 6px; border: 1px solid #e2e8f0; }

        /* Footer */
        .footer {
            background: #0f2c59;
            border-radius: 0 0 16px 16px;
            padding: 28px 40px;
            text-align: center;
        }
        .footer p { color: rgba(255,255,255,0.5); font-size: 12px; line-height: 1.8; }
        .footer a { color: #facc15; text-decoration: none; }
        .footer .footer-brand { color: white; font-size: 15px; font-weight: 700; margin-bottom: 6px; }
        .footer-divider { border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 16px 0; }

        /* Responsive */
        @media (max-width: 600px) {
            .header, .body { padding-left: 24px; padding-right: 24px; }
            .reg-box .reg-number { font-size: 20px; letter-spacing: 2px; }
            .success-banner { padding-left: 24px; padding-right: 24px; }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- HEADER -->
    <div class="header">
        <div class="header-logo">
            <div class="header-logo-inner">
                <span>🎓 STMIK ROSMA</span>
            </div>
        </div>
        <h1>Penerimaan Mahasiswa Baru</h1>
        <p>Tahun Akademik {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <!-- SUCCESS BANNER -->
    <div class="success-banner">
        <div class="success-icon">✓</div>
        <div>
            <h2>Pendaftaran Berhasil Diterima!</h2>
            <p>Formulir dan berkas Anda sudah masuk ke sistem PMB STMIK ROSMA.</p>
        </div>
    </div>

    <!-- BODY -->
    <div class="body">

        <p class="greeting">
            Yth. <strong>{{ $application->form_data['full_name'] ?? 'Calon Mahasiswa' }}</strong>,<br><br>
            Terima kasih telah mendaftar di <strong>STMIK ROSMA</strong>. Pendaftaran Anda telah berhasil kami terima dan sedang dalam proses verifikasi oleh tim administrasi PMB.
        </p>

        <!-- NOMOR REGISTRASI -->
        <div class="reg-box">
            <div class="reg-label">📋 Nomor Registrasi Anda</div>
            <div class="reg-number">{{ $application->application_number }}</div>
            <div class="reg-note">Simpan nomor ini untuk melacak status pendaftaran Anda</div>
        </div>

        <!-- DETAIL PENDAFTARAN -->
        <div class="section-title">📄 Rincian Pendaftaran</div>
        <table class="info-table">
            <tr>
                <td>Nama Lengkap</td>
                <td>{{ $application->form_data['full_name'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>{{ $application->form_data['nik'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $application->form_data['email'] ?? ($application->user->email ?? '-') }}</td>
            </tr>
            <tr>
                <td>No. WhatsApp</td>
                <td>{{ $application->form_data['phone'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jalur Pendaftaran</td>
                <td>{{ $application->registrationPath->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pilihan Prodi 1</td>
                <td><span class="badge-prodi">{{ $application->programStudy->name ?? '-' }}</span></td>
            </tr>
            @if($application->programStudy2)
            <tr>
                <td>Pilihan Prodi 2</td>
                <td><span class="badge-prodi alt">{{ $application->programStudy2->name }}</span></td>
            </tr>
            @endif
            <tr>
                <td>Tipe Kelas</td>
                <td>{{ $application->form_data['class_type'] ?? 'Reguler' }}</td>
            </tr>
            <tr>
                <td>Tanggal Daftar</td>
                <td>{{ $application->created_at->format('d M Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td>Status</td>
                <td><span class="badge-status">⏳ Menunggu Verifikasi</span></td>
            </tr>
        </table>

        <!-- ALUR PROSES -->
        <div class="section-title">🔄 Alur Proses Penerimaan</div>
        <table class="steps">
            <tr>
                <td class="step">
                    <div class="step-num done">✓</div>
                    <div class="step-title">Isi Formulir</div>
                    <div class="step-sub">Selesai</div>
                </td>
                <td class="step">
                    <div class="step-num done">✓</div>
                    <div class="step-title">Pembayaran</div>
                    <div class="step-sub">Selesai</div>
                </td>
                <td class="step">
                    <div class="step-num active">⏳</div>
                    <div class="step-title">Verifikasi</div>
                    <div class="step-sub">Proses 1–2 hari</div>
                </td>
                <td class="step">
                    <div class="step-num" style="background:#e2e8f0;color:#94a3b8;">4</div>
                    <div class="step-title">Hasil Seleksi</div>
                    <div class="step-sub">Menunggu</div>
                </td>
            </tr>
        </table>

        <!-- NOTIFIKASI INFO -->
        <div class="notice-box">
            <p>
                <strong>⏱ Estimasi waktu verifikasi: 1–2 hari kerja.</strong><br>
                Tim Admin PMB akan menghubungi Anda melalui <strong>Email</strong> dan <strong>WhatsApp ({{ $application->form_data['phone'] ?? '-' }})</strong>
                apabila ada kekurangan berkas atau setelah status diperbarui. Mohon cek <strong>inbox & folder Spam</strong> email Anda secara berkala.
            </p>
        </div>

        <!-- CEK STATUS -->
        <div class="cta-wrap">
            <a href="{{ route('applications.status', ['search' => $application->application_number]) }}" class="cta-btn">
                🔍 Cek Status Pendaftaran Real-Time
            </a><br>
            <a href="{{ route('login') }}" class="cta-btn-secondary">
                Masuk ke Dashboard Saya
            </a>
        </div>

        <!-- AKUN LOGIN -->
        <div class="section-title">🔐 Akun Dashboard PMB Anda</div>
        <p style="font-size:13px; color:#64748b; margin-bottom:12px;">Gunakan kredensial berikut untuk mengakses dashboard calon mahasiswa:</p>
        <div class="cred-box">
            <div class="cred-row">
                <span class="cred-label">🌐 URL Dashboard</span>
                <span class="cred-value">{{ url('/dashboard') }}</span>
            </div>
            <div class="cred-row" style="border-top:1px solid #f1f5f9; margin-top:4px; padding-top:10px;">
                <span class="cred-label">📧 Email Login</span>
                <span class="cred-value">{{ $application->user->email ?? $application->form_data['email'] ?? '-' }}</span>
            </div>
            <div class="cred-row" style="border-top:1px solid #f1f5f9; margin-top:4px; padding-top:10px;">
                <span class="cred-label">🔑 Password Default</span>
                <span class="cred-value">No. HP ({{ $application->form_data['phone'] ?? '-' }})</span>
            </div>
        </div>
        <p style="font-size:11px; color:#94a3b8; margin-top:8px;">
            * Segera ubah password setelah login pertama untuk keamanan akun Anda.
        </p>

    </div><!-- end body -->

    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-brand">🎓 STMIK ROSMA</div>
        <p>Sekolah Tinggi Manajemen dan Ilmu Komputer ROSMA<br>
        Karawang, Jawa Barat, Indonesia</p>
        <hr class="footer-divider">
        <p>
            Email ini dikirim secara otomatis oleh sistem PMB STMIK ROSMA.<br>
            Jangan balas email ini. Untuk bantuan hubungi:
            <a href="mailto:pmb@stmik-rosma.ac.id">pmb@stmik-rosma.ac.id</a>
        </p>
        <p style="margin-top:10px; font-size:11px;">
            © {{ date('Y') }} STMIK ROSMA. Seluruh hak cipta dilindungi.
        </p>
    </div>

</div>
</body>
</html>
