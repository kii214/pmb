@extends('layouts.public')

@section('title', 'Cek Status Pendaftaran - PMB STMIK ROSMA')

@section('content')
<section class="py-5" style="background: linear-gradient(135deg, #f0f4f9 0%, #e6edf7 100%); min-height: 80vh;">
    <div class="container py-4">
        <!-- Header Section -->
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill mb-2">
                <i class="bi bi-search me-1"></i> Tracking Pendaftaran
            </span>
            <h1 class="fw-bold text-navy display-6 mb-2">Cek Status Pendaftaran Mahasiswa Baru</h1>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Pantau progres verifikasi berkas, status seleksi, dan status administrasi pendaftaran PMB STMIK ROSMA secara real-time.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Search Box Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('applications.status') }}" method="GET">
                            <label class="form-label fw-bold text-dark mb-2">Masukkan Nomor Registrasi / NIK / Email / No. HP</label>
                            <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                <span class="input-group-text bg-white border-end-0 text-muted px-3">
                                    <i class="bi bi-upc-scan fs-5 text-primary"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       class="form-control border-start-0 ps-0" 
                                       placeholder="Contoh: PMB-20261023-ABCD atau 321501..." 
                                       value="{{ request('search') }}" 
                                       required>
                                <button class="btn btn-primary px-4 fw-semibold" type="submit">
                                    <i class="bi bi-search me-1"></i> Cari Data
                                </button>
                            </div>
                            <div class="form-text mt-2 text-muted">
                                <i class="bi bi-info-circle me-1"></i> Nomor Registrasi didapatkan saat Anda menyelesaikan pendaftaran atau tertera pada email konfirmasi.
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Search Results -->
                @if(request()->has('search'))
                    @if($application)
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" data-aos="fade-up">
                            <!-- Card Header -->
                            <div class="card-header bg-navy text-white p-4 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background-color: #0f2c59;">
                                <div>
                                    <div class="small text-white-50 text-uppercase fw-semibold letter-spacing-1">Nomor Registrasi</div>
                                    <h4 class="mb-0 fw-bold font-monospace text-warning">{{ $application->application_number }}</h4>
                                </div>
                                <div>
                                    @php
                                        $statusClass = 'secondary';
                                        $statusText = 'Draft / Menunggu Verifikasi';
                                        if ($application->status === 'verified') {
                                            $statusClass = 'info text-dark';
                                            $statusText = 'Berkas Terverifikasi';
                                        } elseif ($application->status === 'approved' || $application->status === 'accepted') {
                                            $statusClass = 'success';
                                            $statusText = 'Lolos Seleksi / Diterima';
                                        } elseif ($application->status === 'rejected') {
                                            $statusClass = 'danger';
                                            $statusText = 'Belum Lolos';
                                        } elseif ($application->status === 'submitted') {
                                            $statusClass = 'primary';
                                            $statusText = 'Menunggu Validasi Dokumen';
                                        }
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }} fs-6 px-3 py-2 rounded-pill">
                                        {{ $statusText }}
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-4 p-md-5">
                                <!-- Status Timeline / Stepper -->
                                <div class="mb-5">
                                    <h6 class="fw-bold text-dark mb-4"><i class="bi bi-bar-chart-steps text-primary me-2"></i>Alur Proses Penerimaan</h6>
                                    <div class="row g-3 text-center">
                                        <div class="col-3">
                                            <div class="p-3 rounded-4 {{ $application->id ? 'bg-success-subtle text-success' : 'bg-light text-muted' }} mb-2">
                                                <i class="bi bi-check-circle-fill fs-3"></i>
                                            </div>
                                            <div class="fw-bold small">1. Pendaftaran</div>
                                            <span class="badge bg-success-subtle text-success rounded-pill mt-1">Selesai</span>
                                        </div>
                                        <div class="col-3">
                                            <div class="p-3 rounded-4 {{ in_array($application->payment_status, ['verified', 'paid', 'approved']) ? 'bg-success-subtle text-success' : ($application->payment_status === 'uploaded' ? 'bg-warning-subtle text-warning' : 'bg-light text-muted') }} mb-2">
                                                <i class="bi {{ in_array($application->payment_status, ['verified', 'paid', 'approved']) ? 'bi-check-circle-fill' : 'bi-credit-card-2-front' }} fs-3"></i>
                                            </div>
                                            <div class="fw-bold small">2. Pembayaran</div>
                                            @if(in_array($application->payment_status, ['verified', 'paid', 'approved']))
                                                <span class="badge bg-success-subtle text-success rounded-pill mt-1">Lunas</span>
                                            @elseif($application->payment_status === 'uploaded')
                                                <span class="badge bg-warning-subtle text-warning rounded-pill mt-1">Dicek</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill mt-1">Pending</span>
                                            @endif
                                        </div>
                                        <div class="col-3">
                                            <div class="p-3 rounded-4 {{ in_array($application->status, ['verified', 'approved', 'accepted']) ? 'bg-success-subtle text-success' : 'bg-light text-muted' }} mb-2">
                                                <i class="bi {{ in_array($application->status, ['verified', 'approved', 'accepted']) ? 'bi-check-circle-fill' : 'bi-file-earmark-check' }} fs-3"></i>
                                            </div>
                                            <div class="fw-bold small">3. Verifikasi</div>
                                            @if(in_array($application->status, ['verified', 'approved', 'accepted']))
                                                <span class="badge bg-success-subtle text-success rounded-pill mt-1">Valid</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill mt-1">Proses</span>
                                            @endif
                                        </div>
                                        <div class="col-3">
                                            <div class="p-3 rounded-4 {{ in_array($application->status, ['approved', 'accepted']) ? 'bg-success-subtle text-success' : ($application->status === 'rejected' ? 'bg-danger-subtle text-danger' : 'bg-light text-muted') }} mb-2">
                                                <i class="bi {{ in_array($application->status, ['approved', 'accepted']) ? 'bi-trophy-fill' : 'bi-mortarboard' }} fs-3"></i>
                                            </div>
                                            <div class="fw-bold small">4. Hasil Seleksi</div>
                                            @if(in_array($application->status, ['approved', 'accepted']))
                                                <span class="badge bg-success rounded-pill text-white mt-1">Diterima</span>
                                            @elseif($application->status === 'rejected')
                                                <span class="badge bg-danger rounded-pill text-white mt-1">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill mt-1">Menunggu</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Detail Data Peserta -->
                                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-badge text-primary me-2"></i>Rincian Calon Mahasiswa</h6>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <div class="text-muted small">Nama Lengkap</div>
                                            <div class="fw-bold text-dark fs-6">{{ $application->form_data['full_name'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <div class="text-muted small">Jalur Pendaftaran</div>
                                            <div class="fw-bold text-dark fs-6">{{ $application->registrationPath->name ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <div class="text-muted small">Pilihan Program Studi 1</div>
                                            <div class="fw-bold text-primary fs-6">{{ $application->programStudy->name ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <div class="text-muted small">Pilihan Program Studi 2</div>
                                            <div class="fw-bold text-secondary fs-6">{{ $application->programStudy2 ? $application->programStudy2->name : '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <div class="text-muted small">Sekolah Asal</div>
                                            <div class="fw-semibold text-dark">{{ $application->form_data['school_name'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <div class="text-muted small">Tanggal Pendaftaran</div>
                                            <div class="fw-semibold text-dark">{{ $application->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4 pt-3 d-flex flex-wrap gap-3 align-items-center justify-content-between border-top">
                                    <div class="text-muted small">
                                        <i class="bi bi-shield-check text-success me-1"></i> Data diverifikasi resmi oleh STMIK ROSMA
                                    </div>
                                    <div class="d-flex gap-2">
                                        @auth
                                            <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 fw-semibold rounded-pill">
                                                <i class="bi bi-grid-fill me-1"></i> Buka Dashboard Saya
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary px-4 fw-semibold rounded-pill">
                                                <i class="bi bi-box-arrow-in-right me-1"></i> Login Dashboard
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Data Tidak Ditemukan -->
                        <div class="card border-0 shadow-sm rounded-4 text-center p-5" data-aos="fade-up">
                            <div class="mb-3">
                                <div class="d-inline-flex p-3 rounded-circle bg-danger-subtle text-danger">
                                    <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Data Pendaftaran Tidak Ditemukan</h4>
                            <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
                                Tidak ada data pendaftaran yang cocok dengan kata kunci <strong>"{{ request('search') }}"</strong>. Mohon pastikan kembali Nomor Registrasi, NIK, atau Email yang Anda masukkan sudah benar.
                            </p>
                            <div>
                                <a href="{{ route('applications.create') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold me-2">
                                    <i class="bi bi-pencil-square me-1"></i> Daftar Sekarang
                                </a>
                                <a href="{{ route('applications.status') }}" class="btn btn-light rounded-pill px-4 fw-semibold">
                                    <i class="bi bi-arrow-repeat me-1"></i> Reset Pencarian
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
