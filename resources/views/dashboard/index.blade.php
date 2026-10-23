@extends('layouts.public')

@section('title', 'Dashboard Calon Mahasiswa')

@push('styles')
<style>
    .dashboard-camaba {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 80px;
    }
    .hero-camaba {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
        padding: 60px 0 100px;
    }
    .status-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        padding: 30px;
        margin-top: -60px;
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .step-indicator {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 40px;
    }
    .step-indicator::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 0;
        right: 0;
        height: 4px;
        background: #e2e8f0;
        z-index: 1;
        border-radius: 4px;
    }
    .step-item {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }
    .step-circle {
        width: 52px;
        height: 52px;
        background: white;
        border: 4px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-weight: bold;
        color: #94a3b8;
        background: #f8fafc;
        transition: all 0.3s;
    }
    .step-item.active .step-circle {
        border-color: #3b82f6;
        background: #eff6ff;
        color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
    }
    .step-item.completed .step-circle {
        background: #22c55e;
        border-color: #22c55e;
        color: white;
    }
    .step-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
    }
    .step-item.active .step-label { color: #1e293b; }

    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 20px;
    }
    .bank-card {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
        border-radius: 16px;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }
    .bank-card::after {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        right: -30px;
        bottom: -50px;
    }
    /* Nomor Pendaftaran Hero Box */
    .reg-number-hero {
        background: linear-gradient(135deg, #0f2c59, #1e4fa0);
        border-radius: 20px;
        padding: 28px 30px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .reg-number-hero::before {
        content: '';
        position: absolute;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        top: -60px; right: -60px;
    }
    .reg-number-hero .reg-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; opacity: 0.6; margin-bottom: 6px; }
    .reg-number-hero .reg-code { font-size: 1.5rem; font-weight: 900; font-family: monospace; letter-spacing: 3px; color: #facc15; margin-bottom: 4px; }
    .reg-number-hero .reg-copy-btn { font-size: 0.75rem; background: rgba(255,255,255,0.15); border: none; color: rgba(255,255,255,0.8); border-radius: 20px; padding: 4px 14px; cursor: pointer; transition: background 0.2s; }
    .reg-number-hero .reg-copy-btn:hover { background: rgba(255,255,255,0.25); }
    .waiting-pulse { display: inline-block; width: 10px; height: 10px; background: #22c55e; border-radius: 50%; margin-right: 6px; animation: pulse-dot 1.5s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,0.4)} 50%{box-shadow:0 0 0 8px rgba(34,197,94,0)} }
    .notif-channel { display: flex; align-items: center; gap: 12px; background: white; border-radius: 12px; padding: 14px 18px; border: 1px solid #e2e8f0; margin-bottom: 10px; }
    .notif-channel .ch-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .notif-channel .ch-text { flex: 1; }
    .notif-channel .ch-text strong { display: block; font-size: 0.9rem; margin-bottom: 2px; }
    .notif-channel .ch-text span { font-size: 0.78rem; color: #64748b; }
</style>
@endpush

@section('content')
<div class="dashboard-camaba">
    {{-- HERO --}}
    <div class="hero-camaba">
        <div class="container">
            <h1 class="fw-bold mb-2">Halo, {{ auth()->user()->name }} 👋</h1>
            <p class="mb-0 opacity-75 fs-5">Selamat datang di Dashboard Calon Mahasiswa Baru STMIK ROSMA.</p>
        </div>
    </div>

    <div class="container">
        {{-- MAIN STATUS CARD --}}
        <div class="status-card">
            
            @if(session('success'))
                <div class="alert alert-success rounded-4 border-0 mb-4 fw-medium">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
                <script>try { localStorage.removeItem('pmb_rosma_form_draft_v1'); } catch(e) {}</script>
            @endif
            @if(session('error'))
                <div class="alert alert-danger rounded-4 border-0 mb-4 fw-medium">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            @if(!$application)
                {{-- BELUM DAFTAR SAMA SEKALI --}}
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/2950/2950293.png" alt="Daftar" style="width: 120px; opacity:0.7" class="mb-4">
                    <h3 class="fw-bold">Anda Belum Mengisi Form Pendaftaran</h3>
                    <p class="text-muted mb-4">Silakan lengkapi biodata dan pilihan program studi Anda terlebih dahulu.</p>
                    <a href="{{ route('applications.create') }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow">
                        <i class="bi bi-pencil-square me-2"></i>Isi Form Pendaftaran Sekarang
                    </a>
                </div>
            @else
                {{-- SUDAH MENGISI FORM --}}
                
                @php
                    $step = 1;
                    if($application->payment_status == 'uploaded') $step = 2;
                    if($application->status == 'submitted' || $application->status == 'verified' || $application->status == 'accepted') $step = 3;
                @endphp

                <div class="step-indicator d-none d-md-flex">
                    <div class="step-item {{ $step >= 1 ? 'completed' : 'active' }}">
                        <div class="step-circle"><i class="bi bi-check-lg fs-4"></i></div>
                        <div class="step-label">1. Isi Formulir</div>
                    </div>
                    <div class="step-item {{ $step >= 2 ? 'completed' : ($step == 1 ? 'active' : '') }}">
                        <div class="step-circle">
                            @if($step >= 2) <i class="bi bi-check-lg fs-4"></i> @else 2 @endif
                        </div>
                        <div class="step-label">2. Pembayaran</div>
                    </div>
                    <div class="step-item {{ $step >= 3 ? 'completed' : ($step == 2 ? 'active' : '') }}">
                        <div class="step-circle">
                            @if($step >= 3) <i class="bi bi-check-lg fs-4"></i> @else 3 @endif
                        </div>
                        <div class="step-label">3. Verifikasi Admin</div>
                    </div>
                </div>

                <div class="row g-5">
                    {{-- KIRI: INFO PENDAFTARAN --}}
                    <div class="col-lg-6">
                        <h5 class="fw-bold mb-4">Informasi Pendaftaran Anda</h5>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted ps-0" width="40%">Nomor Pendaftaran</td>
                                    <td class="fw-bold text-end pe-0">{{ $application->application_number }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Pilihan Prodi 1</td>
                                    <td class="fw-bold text-end pe-0 text-primary">{{ $application->programStudy?->name ?? '-' }} ({{ $application->programStudy?->level ?? '' }})</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Pilihan Prodi 2</td>
                                    <td class="fw-semibold text-end pe-0 text-secondary">{{ $application->programStudy2 ? ($application->programStudy2->name . ' (' . $application->programStudy2->level . ')') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Jalur Penerimaan</td>
                                    <td class="fw-bold text-end pe-0">{{ $application->registrationPath?->name ?? '-' }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="text-muted ps-0 pt-3">Status Saat Ini</td>
                                    <td class="text-end pe-0 pt-3">
                                        @if($application->status == 'draft')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Draft (Belum Dikirim)</span>
                                        @elseif($application->status == 'submitted')
                                            <span class="badge bg-info text-white rounded-pill px-3 py-2">Menunggu Verifikasi Admin</span>
                                        @elseif($application->status == 'verified')
                                            <span class="badge bg-primary text-white rounded-pill px-3 py-2">Diverifikasi (Berkas Lengkap)</span>
                                        @elseif($application->status == 'accepted')
                                            <span class="badge bg-success text-white rounded-pill px-3 py-2">DITERIMA (Lulus) 🎉</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- KANAN: ACTION AREA --}}
                    <div class="col-lg-6">
                        @if($step == 1)
                            {{-- Nomor Pendaftaran Awal --}}
                            <div class="reg-number-hero mb-4">
                                <div class="reg-label"><i class="bi bi-upc-scan me-1"></i> Nomor Registrasi Anda</div>
                                <div class="reg-code" id="regNumberDisplay">{{ $application->application_number }}</div>
                                <button class="reg-copy-btn mt-2" onclick="copyRegNumber()">
                                    <i class="bi bi-clipboard me-1"></i> Salin Nomor
                                </button>
                                <div class="mt-3">
                                    <a href="{{ route('applications.status', ['search' => $application->application_number]) }}"
                                       target="_blank"
                                       class="btn btn-warning btn-sm fw-bold rounded-pill px-4">
                                        <i class="bi bi-search me-1"></i> Cek Status Pendaftaran
                                    </a>
                                </div>
                            </div>

                            {{-- HARUS BAYAR & UPLOAD --}}
                            <div class="info-box mb-4">
                                <h5 class="fw-bold text-primary mb-3">Langkah 2: Selesaikan Pembayaran</h5>
                                <p class="text-secondary small mb-3">Untuk melanjutkan, silakan transfer biaya registrasi pendaftaran ke rekening resmi STMIK ROSMA di bawah ini.</p>
                                
                                <div class="bank-card mb-3">
                                    <div class="text-uppercase text-white-50 small fw-bold mb-1">Bank Tujuan</div>
                                    <div class="fs-4 fw-bold mb-3">{{ $setting?->bank_name ?? 'BCA' }}</div>
                                    
                                    <div class="text-uppercase text-white-50 small fw-bold mb-1">Nomor Rekening</div>
                                    <div class="fs-3 fw-bold mb-3 font-monospace letter-spacing-1">{{ $setting?->bank_account ?? '1234567890' }}</div>
                                    
                                    <div class="text-uppercase text-white-50 small fw-bold mb-1">Atas Nama</div>
                                    <div class="fw-bold">{{ $setting?->account_name ?? 'STMIK ROSMA' }}</div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-3 border">
                                    <span class="fw-bold text-muted">Nominal Transfer:</span>
                                    <span class="fs-4 fw-bold text-danger">Rp {{ number_format($fee?->amount ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <form action="{{ route('applications.payment.upload') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-4 border shadow-sm">
                                @csrf
                                <label class="form-label fw-bold">Upload Bukti Transfer</label>
                                <input type="file" name="payment_proof" class="form-control mb-3" accept="image/jpeg,image/png,image/jpg" required>
                                <small class="text-muted d-block mb-3">Format: JPG/PNG, Maksimal: 2MB</small>
                                <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill shadow">
                                    <i class="bi bi-cloud-arrow-up me-1"></i> Unggah Bukti
                                </button>
                            </form>

                        @elseif($step == 2)
                            {{-- SUDAH UPLOAD, HARUS SUBMIT FINAL --}}
                            <div class="bg-success-subtle border border-success border-opacity-25 rounded-4 p-4 text-center mb-4">
                                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px;">
                                    <i class="bi bi-check2-circle fs-1"></i>
                                </div>
                                <h4 class="fw-bold text-success mb-2">Bukti Berhasil Diunggah!</h4>
                                <p class="text-muted mb-4">Seluruh persyaratan telah lengkap. Klik tombol di bawah ini untuk mengirim formulir Anda ke Admin PMB untuk diverifikasi.</p>
                                
                                <form action="{{ route('applications.submit') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold rounded-pill shadow" onclick="return confirm('Apakah Anda yakin semua data sudah benar? Data tidak bisa diubah setelah dikirim.')">
                                        <i class="bi bi-send-fill me-2"></i> Kirim Pendaftaran Sekarang
                                    </button>
                                </form>
                            </div>
                        
                        @elseif($step == 3)
                            {{-- MENUNGGU VERIFIKASI ADMIN --}}

                            {{-- Nomor Pendaftaran Menonjol --}}
                            <div class="reg-number-hero">
                                <div class="reg-label"><i class="bi bi-upc-scan me-1"></i> Nomor Registrasi Anda</div>
                                <div class="reg-code" id="regNumberDisplay">{{ $application->application_number }}</div>
                                <button class="reg-copy-btn mt-2" onclick="copyRegNumber()">
                                    <i class="bi bi-clipboard me-1"></i> Salin Nomor
                                </button>
                                <div class="mt-3">
                                    <a href="{{ route('applications.status', ['search' => $application->application_number]) }}"
                                       target="_blank"
                                       class="btn btn-warning btn-sm fw-bold rounded-pill px-4">
                                        <i class="bi bi-search me-1"></i> Cek Status Pendaftaran
                                    </a>
                                </div>
                            </div>

                            {{-- Status Menunggu Verifikasi --}}
                            <div class="bg-amber-50 border rounded-4 p-4 mb-3" style="background:#fffbeb; border-color:#fcd34d !important;">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div style="width:48px;height:48px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;">⏳</div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size:1rem;">
                                            <span class="waiting-pulse"></span>Mohon Tunggu — Verifikasi Sedang Diproses
                                        </div>
                                        <div class="text-muted small">Tim Admin PMB STMIK ROSMA sedang memeriksa berkas & bukti pembayaran Anda.</div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-3 p-3 border" style="font-size:0.82rem; color:#78350f;">
                                    <i class="bi bi-info-circle-fill me-1 text-warning"></i>
                                    Proses verifikasi biasanya membutuhkan <strong>1–2 hari kerja</strong>. Anda akan dihubungi oleh Admin jika ada kekurangan atau setelah status diperbarui.
                                </div>
                            </div>

                            {{-- Cek Notifikasi Via --}}
                            <p class="fw-bold text-dark mb-2" style="font-size:0.9rem;"><i class="bi bi-bell-fill text-primary me-1"></i> Pantau Notifikasi Melalui:</p>
                            <div class="notif-channel">
                                <div class="ch-icon" style="background:#dbeafe;"><i class="bi bi-envelope-fill text-primary"></i></div>
                                <div class="ch-text">
                                    <strong>Email</strong>
                                    <span>Cek inbox & folder <em>Spam/Junk</em> pada email Anda: <strong>{{ auth()->user()->email }}</strong></span>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                            <div class="notif-channel">
                                <div class="ch-icon" style="background:#dcfce7;"><i class="bi bi-whatsapp text-success"></i></div>
                                <div class="ch-text">
                                    <strong>WhatsApp (WA)</strong>
                                    <span>Admin akan menghubungi nomor WA: <strong>{{ $application->form_data['phone'] ?? '-' }}</strong></span>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                            <div class="notif-channel">
                                <div class="ch-icon" style="background:#f3e8ff;"><i class="bi bi-search text-purple" style="color:#7c3aed;"></i></div>
                                <div class="ch-text">
                                    <strong>Halaman Cek Status</strong>
                                    <span>Gunakan No. Registrasi di atas pada halaman <a href="{{ route('applications.status') }}" target="_blank">Cek Status Pendaftaran</a></span>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>

                        @endif
                    </div>
                </div>

            @endif
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

@push('scripts')
<script>
function copyRegNumber() {
    const code = document.getElementById('regNumberDisplay')?.innerText?.trim();
    if (!code) return;
    navigator.clipboard.writeText(code).then(() => {
        const btn = document.querySelector('.reg-copy-btn');
        if (btn) {
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check2 me-1"></i> Tersalin!';
            btn.style.background = 'rgba(34,197,94,0.3)';
            setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; }, 2000);
        }
    }).catch(() => {
        // Fallback for older browsers
        const ta = document.createElement('textarea');
        ta.value = code;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        alert('Nomor registrasi disalin: ' + code);
    });
}
</script>
@endpush

@endsection
