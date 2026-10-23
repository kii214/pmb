@extends('layouts.public')

@section('title', 'Biaya Kuliah - PMB STMIK ROSMA')

@push('styles')
<style>
    /* View Transition for Chrome */
    @view-transition { navigation: auto; }
    
    .fee-hero {
        background: linear-gradient(135deg, #0a1535, #1e3a8a);
        color: white;
        padding: 60px 0 100px;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
    }
    .filter-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        margin-top: -60px;
        position: relative;
        z-index: 10;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .modern-select {
        appearance: none;
        background-color: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 600;
        color: #1e293b;
        width: 100%;
        transition: all 0.3s ease;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
    }
    .modern-select:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        background-color: white;
    }
    .fee-table-wrap {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        margin-top: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        opacity: 1;
        transition: opacity 0.4s ease, transform 0.4s ease;
    }
    .fee-table-wrap.loading {
        opacity: 0.4;
        transform: scale(0.98);
        pointer-events: none;
    }
    .fee-header-title {
        font-weight: 800;
        color: #0f172a;
        font-size: 1.5rem;
    }
    .fee-badge {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .modern-table {
        margin-top: 20px;
    }
    .modern-table th {
        background: #f8fafc;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        color: #64748b;
        border-bottom: 2px solid #e2e8f0;
        padding: 16px;
    }
    .modern-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 500;
        color: #334155;
    }
    .modern-table tbody tr:hover td {
        background-color: #f8fafc;
    }
    .modern-table tfoot th, .modern-table tfoot td {
        background: #eff6ff;
        font-size: 1.1rem;
        padding: 20px 16px;
        border-bottom: none;
        color: #1e40af;
    }
    .modern-table tfoot td {
        font-weight: 800;
    }
    /* Loading overlay */
    #loading-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
</style>
<meta name="view-transition" content="same-origin" />
@endpush

@section('content')
    <div id="loading-overlay">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-3 fw-bold text-primary">Memuat Biaya Pendidikan...</div>
    </div>

    <section class="fee-hero text-center">
        <div class="container">
            <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold tracking-wide">BIAYA PENDIDIKAN</span>
            <h1 class="fw-bold mb-3">Transparansi Biaya Kuliah</h1>
            <p class="text-white-50 fs-5 mb-0" style="max-width: 600px; margin: 0 auto;">Pilih Program Studi dan Jalur Pendaftaran Anda untuk melihat rincian biaya yang berlaku.</p>
        </div>
    </section>

    <section class="section-block pb-5">
        <div class="container">
            <div class="filter-card">
                <form id="feeForm" method="GET" action="{{ route('fees.index') }}">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Program Studi</label>
                            <select class="modern-select" name="program_id" onchange="triggerLoad()">
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ $selectedProgram && $selectedProgram->id == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Jalur Masuk</label>
                            <select class="modern-select" name="path_id" onchange="triggerLoad()">
                                @foreach($paths as $path)
                                    <option value="{{ $path->id }}" {{ $selectedPath && $selectedPath->id == $path->id ? 'selected' : '' }}>{{ $path->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Gelombang</label>
                            <select class="modern-select" name="wave_id" onchange="triggerLoad()">
                                @foreach($waves as $wave)
                                    <option value="{{ $wave->id }}" {{ $selectedWave && $selectedWave->id == $wave->id ? 'selected' : '' }}>{{ $wave->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            @if($selectedProgram && $selectedPath && $selectedWave)
                <div class="fee-table-wrap" id="feeTableWrapper">
                    @php
                        $isScholarship = \Illuminate\Support\Str::contains(strtolower($selectedPath->name), ['beasiswa', 'kip', 'yaperos']);
                        $waNum = preg_replace('/[^0-9]/', '', $setting->whatsapp_number ?? '6281234567890');
                        $waText = urlencode("Halo Admin PMB STMIK ROSMA, saya ingin menanyakan persyaratan dan kuota pendaftaran Jalur " . $selectedPath->name . " untuk Prodi " . $selectedProgram->name . " (" . $selectedProgram->level . ").");
                    @endphp

                    @if($isScholarship)
                        {{-- ================= TAMPILAN KHUSUS JALUR BEASISWA ================= --}}
                        <div class="p-2 p-md-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom gap-3">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 0.8rem;">
                                            <i class="bi bi-mortarboard-fill me-1"></i> PROGRAM BEASISWA
                                        </span>
                                        <span class="fee-badge"><i class="bi bi-calendar-event me-1"></i> {{ $selectedWave->name }}</span>
                                    </div>
                                    <h3 class="fee-header-title mb-1">{{ $selectedProgram->name }} ({{ $selectedProgram->level }})</h3>
                                    <p class="text-muted mb-0"><i class="bi bi-award text-warning me-1"></i> Jalur Masuk: <strong>{{ $selectedPath->name }}</strong></p>
                                </div>
                                <div class="text-md-end">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-3 fs-6 fw-bold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Subsidi / Bebas Biaya Kuliah
                                    </span>
                                </div>
                            </div>

                            <div class="alert alert-info border-0 rounded-4 p-4 mb-4 shadow-sm" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.4rem;">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">Informasi Biaya Pendidikan Jalur {{ $selectedPath->name }}</h5>
                                        <p class="text-secondary mb-0" style="line-height: 1.6;">
                                            Untuk <strong>{{ $selectedPath->name }}</strong>, mahasiswa tidak dikenakan biaya kuliah reguler atau mendapatkan bantuan pembiayaan penuh sesuai ketentuan skema {{ str_contains(strtolower($selectedPath->name), 'kip') ? 'KIP Kuliah dari Pemerintah RI' : 'Beasiswa Yayasan Pendidikan Rosma (YAPEROS)' }}.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- DUA AKSI UTAMA: Tanyakan di Admin & Isi Biodata di Penerimaan --}}
                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center d-flex flex-column" style="background:#f0fdf4; border: 2px dashed #86efac !important;">
                                        <div class="mx-auto mb-3 bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; font-size: 1.8rem;">
                                            <i class="bi bi-whatsapp"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2">1. Tanyakan di Admin PMB</h5>
                                        <p class="text-muted small mb-4 flex-grow-1">
                                            Konsultasikan kuota kuota penerimaan, persyaratan berkas khusus, dan informasi seleksi beasiswa langsung bersama tim admisi kami.
                                        </p>
                                        <a href="https://wa.me/{{ $waNum }}?text={{ $waText }}" target="_blank" class="btn btn-success fw-bold py-2 px-4 rounded-pill shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                                            <i class="bi bi-whatsapp"></i>
                                            <span>Chat WhatsApp Admin</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center d-flex flex-column" style="background:#eff6ff; border: 2px dashed #93c5fd !important;">
                                        <div class="mx-auto mb-3 bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; font-size: 1.8rem;">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2">2. Isi Biodata di Penerimaan</h5>
                                        <p class="text-muted small mb-4 flex-grow-1">
                                            Sudah siap mendaftar? Silakan isi data diri, riwayat pendidikan, dan nomor KIP / berkas prestasi Anda pada formulir penerimaan mahasiswa baru.
                                        </p>
                                        <a href="{{ route('applications.create') }}" class="btn btn-primary fw-bold py-2 px-4 rounded-pill shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Isi Formulir Pendaftaran</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 text-center border-top">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check text-success me-1"></i> Proses verifikasi beasiswa dilakukan secara transparan dan akuntabel oleh Tim PMB STMIK ROSMA.
                                </small>
                            </div>
                        </div>

                    @else
                        {{-- ================= TAMPILAN BIAYA JALUR REGULER, EKSTENSI, RPL ================= --}}
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
                            <div>
                                <h3 class="fee-header-title mb-2">{{ $selectedProgram->name }}</h3>
                                <div class="d-flex gap-2">
                                    <span class="fee-badge"><i class="bi bi-signpost-split me-1"></i> {{ $selectedPath->name }}</span>
                                    <span class="fee-badge"><i class="bi bi-calendar-event me-1"></i> {{ $selectedWave->name }}</span>
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0 text-md-end">
                                <div class="text-muted small fw-bold text-uppercase mb-1">Total Biaya Masuk</div>
                                <h2 class="text-primary fw-bold mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table modern-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Komponen Biaya</th>
                                        <th class="text-end">Nominal (Rupiah)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fees as $fee)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-cash-stack"></i>
                                                    </div>
                                                    <span class="fw-bold">{{ $fee->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end fs-5 fw-bold text-dark">
                                                Rp {{ number_format($fee->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-5">
                                                <i class="bi bi-inbox fs-1 d-block mb-2 text-black-50"></i>
                                                Belum ada rincian biaya untuk kombinasi ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if(count($fees) > 0)
                                <tfoot>
                                    <tr>
                                        <th>Total Keseluruhan</th>
                                        <td class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>

                        <div class="mt-4 pt-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 border-top">
                            <div class="text-muted small">
                                <i class="bi bi-info-circle me-1 text-primary"></i> Biaya dapat diangsur sesuai skema pembayaran perkuliahan.
                            </div>
                            <a href="{{ route('applications.create') }}" class="btn btn-primary fw-bold px-4 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-pencil-square me-1"></i> Daftar Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
    <script>
        async function triggerLoad() {
            // Animasi loading halus di area tabel saja
            const tableWrap = document.getElementById('feeTableWrapper');
            if (tableWrap) {
                tableWrap.classList.add('loading');
            }
            
            const form = document.getElementById('feeForm');
            const url = new URL(form.action);
            const formData = new FormData(form);
            url.search = new URLSearchParams(formData).toString();
            
            try {
                // Meminta data baru ke server tanpa refresh layar
                const response = await fetch(url);
                const htmlString = await response.text();
                
                // Parse respon HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(htmlString, 'text/html');
                const newTableWrap = doc.getElementById('feeTableWrapper');
                
                if (newTableWrap && tableWrap) {
                    // Ganti isi tabel lama dengan tabel baru
                    tableWrap.innerHTML = newTableWrap.innerHTML;
                    
                    // Beri sedikit waktu untuk render sebelum animasi selesai
                    setTimeout(() => {
                        tableWrap.classList.remove('loading');
                    }, 100);
                } else if (newTableWrap && !tableWrap) {
                    document.querySelector('.filter-card').insertAdjacentHTML('afterend', newTableWrap.outerHTML);
                } else if (!newTableWrap && tableWrap) {
                    tableWrap.remove();
                }
                
                // Ubah URL di atas secara diam-diam
                window.history.replaceState({}, '', url);
                
            } catch (error) {
                console.error("AJAX Error:", error);
                // Jika error, gunakan cara biasa sebagai fallback
                form.submit();
            }
        }
    </script>
    @endpush
@endsection
