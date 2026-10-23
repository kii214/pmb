@extends('layouts.admin')

@section('title', 'Biaya & Voucher')

@push('styles')
<style>
    .wave-card {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
        transition: transform .18s, box-shadow .18s;
        cursor: default;
        overflow: hidden;
    }
    .wave-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 20px rgba(79,70,229,.12);
    }
    .wave-card-top {
        height: 6px;
    }
    .wave-card-current {
        border: 2px solid #f59e0b !important;
        box-shadow: 0 4px 20px rgba(245,158,11,.18), 0 1px 4px rgba(0,0,0,.06) !important;
    }
    .wave-card-current:hover {
        box-shadow: 0 6px 28px rgba(245,158,11,.28) !important;
    }
    .badge-modern {
        padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: .72rem;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .b-success { background:#dcfce7; color:#16a34a; }
    .b-danger  { background:#fee2e2; color:#dc2626; }
    .b-primary { background:#e0e7ff; color:#4f46e5; }
    .b-warning { background:#fef3c7; color:#d97706; }
    .b-muted   { background:#f1f5f9; color:#64748b; }

    .nav-pills-custom .nav-link {
        color:#64748b; font-weight:600; border-radius:10px;
        padding:9px 20px; margin-right:8px; transition:all .2s;
    }
    .nav-pills-custom .nav-link.active {
        background:#4f46e5; color:#fff;
        box-shadow:0 4px 10px rgba(79,70,229,.25);
    }
    .nav-pills-custom .nav-link:hover:not(.active) { background:#f1f5f9; color:#0f172a; }

    .table-voucher thead th {
        background:#f8fafc; border-bottom:1px solid #e2e8f0; color:#64748b;
        font-size:.72rem; font-weight:700; text-transform:uppercase;
        letter-spacing:.5px; padding:14px 18px;
    }
    .table-voucher tbody td {
        padding:14px 18px; vertical-align:middle; border-bottom:1px solid #f1f5f9;
        font-size:.875rem; color:#334155;
    }
    .table-voucher tbody tr:last-child td { border-bottom:none; }
    .table-voucher tbody tr:hover td { background:#f8fafc; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1 text-dark"><i class="bi bi-wallet2 text-primary me-2"></i>Biaya & Voucher</h3>
        <p class="text-muted mb-0" style="font-size:.9rem;">Kelola gelombang pendaftaran, rincian biaya, dan voucher diskon.</p>
    </div>
</div>

<ul class="nav nav-pills nav-pills-custom mb-4" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-waves-tab" data-bs-toggle="pill" data-bs-target="#pills-waves" type="button">
            <i class="bi bi-layers me-1"></i> Gelombang Pendaftaran
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-vouchers-tab" data-bs-toggle="pill" data-bs-target="#pills-vouchers" type="button">
            <i class="bi bi-ticket-perforated me-1"></i> Voucher Diskon
        </button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">

    {{-- ===== TAB GELOMBANG ===== --}}
    <div class="tab-pane fade show active" id="pills-waves" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-muted mb-0 small">Klik kartu gelombang untuk mengatur rincian biayanya.</p>
            <button class="btn btn-primary btn-sm rounded-3 px-3 shadow-sm d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#addWaveModal">
                <i class="bi bi-plus-lg"></i> Tambah Gelombang
            </button>
        </div>

        <div class="row g-4">
            @forelse($waves as $wave)
            <div class="col-md-6 col-xl-4">
                <div class="wave-card {{ $wave->is_current ? 'wave-card-current' : '' }}">
                    {{-- colour bar --}}
                    <div class="wave-card-top" style="background: {{ $wave->is_current ? '#f59e0b' : ($loop->iteration % 3 == 1 ? '#4f46e5' : ($loop->iteration % 3 == 2 ? '#0ea5e9' : '#10b981')) }};"></div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h5 class="fw-bold mb-0 text-dark">{{ $wave->name }}</h5>
                                    @if($wave->is_current)
                                        <span class="badge-modern b-warning" style="background:#fef3c7;color:#b45309;">
                                            <i class="bi bi-star-fill" style="font-size:.6rem;"></i> Aktif Saat Ini
                                        </span>
                                    @endif
                                </div>
                                <span class="text-muted" style="font-size:.8rem;">T.A. {{ $wave->academic_year }}</span>
                            </div>
                            @if($wave->status == 'active')
                                <span class="badge-modern b-success"><i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Aktif</span>
                            @else
                                <span class="badge-modern b-muted"><i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Nonaktif</span>
                            @endif
                        </div>

                        <div class="mb-3 d-flex align-items-center gap-2 text-muted" style="font-size:.82rem;">
                            <i class="bi bi-calendar-range text-primary"></i>
                            <span>{{ $wave->start_date->format('d M Y') }} &rarr; {{ $wave->end_date->format('d M Y') }}</span>
                        </div>

                        <div class="mb-3 d-flex align-items-center gap-2" style="font-size:.82rem;">
                            <span class="badge-modern b-primary">
                                <i class="bi bi-cash-stack"></i> {{ $wave->fees_count }} Komponen Biaya
                            </span>
                        </div>

                        {{-- SET CURRENT BUTTON --}}
                        @if(!$wave->is_current)
                        <form action="{{ route('admin.waves.setCurrent', $wave->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning w-100 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2"
                                    onclick="return confirm('Tetapkan {{ $wave->name }} sebagai gelombang pendaftaran saat ini?')">
                                <i class="bi bi-pin-angle-fill"></i> Tetapkan sebagai Aktif
                            </button>
                        </form>
                        @else
                        <div class="alert alert-warning py-2 px-3 rounded-3 mb-2 d-flex align-items-center gap-2" style="font-size:.82rem;border:1.5px solid #fcd34d;">
                            <i class="bi bi-check2-circle text-warning"></i>
                            <span class="fw-semibold text-warning-emphasis">Gelombang ini sedang menerima pendaftaran</span>
                        </div>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.fees.show', $wave->id) }}"
                               class="btn btn-primary btn-sm rounded-3 flex-fill d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-eye"></i> Lihat Biaya
                            </a>
                            <button class="btn btn-sm btn-outline-secondary rounded-3 px-3"
                                    data-bs-toggle="modal" data-bs-target="#editWaveModal{{ $wave->id }}" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.waves.destroy', $wave->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus gelombang {{ $wave->name }}?');">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger rounded-3 px-3" type="submit" title="Hapus"
                                        {{ $wave->is_current ? 'disabled title=Tidak bisa hapus gelombang aktif' : '' }}>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Edit Wave Modal --}}
            <div class="modal fade" id="editWaveModal{{ $wave->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-bottom-0 pb-0">
                            <h5 class="modal-title fw-bold">Edit Gelombang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.waves.update', $wave->id) }}" method="POST">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Nama Gelombang</label>
                                        <input type="text" name="name" class="form-control" value="{{ $wave->name }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tahun Akademik</label>
                                        <input type="text" name="academic_year" class="form-control" value="{{ $wave->academic_year }}" placeholder="2026/2027" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ $wave->start_date->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tanggal Selesai</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ $wave->end_date->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="active" {{ $wave->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                            <option value="inactive" {{ $wave->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3 opacity-50"></i>
                    <h5 class="fw-bold text-dark">Belum Ada Gelombang</h5>
                    <p class="text-muted small">Buat gelombang pendaftaran pertama Anda.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ===== TAB VOUCHERS ===== --}}
    <div class="tab-pane fade" id="pills-vouchers" role="tabpanel">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded-3 px-3 shadow-sm d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#addVoucherModal">
                <i class="bi bi-plus-lg"></i> Buat Voucher
            </button>
        </div>
        <div class="admin-card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-voucher mb-0">
                    <thead>
                        <tr>
                            <th>#</th><th>Detail Voucher</th><th>Kode Promo</th>
                            <th>Nilai Diskon</th><th>Target</th><th>Berlaku S/d</th>
                            <th>Status</th><th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $voucher)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $voucher->name }}</div>
                                @if($voucher->description)
                                    <div class="text-muted text-truncate" style="font-size:.75rem; max-width:150px;">{{ $voucher->description }}</div>
                                @endif
                            </td>
                            <td><code class="px-2 py-1 bg-light border rounded text-primary fw-bold">{{ $voucher->code }}</code></td>
                            <td class="fw-bold text-success">
                                {{ $voucher->discount_type == 'percent' ? intval($voucher->amount).'%' : 'Rp '.number_format($voucher->amount,0,',','.') }}
                            </td>
                            <td>
                                @if($voucher->target_fee=='all')
                                    <span class="badge-modern b-primary">Semua</span>
                                @elseif($voucher->target_fee=='registration')
                                    <span class="badge-modern b-warning">Pendaftaran</span>
                                @else
                                    <span class="badge-modern" style="background:#f0fdf4;color:#15803d;">UKT</span>
                                @endif
                            </td>
                            <td style="font-size:.82rem;">
                                @if($voucher->valid_until)
                                    <div>{{ $voucher->valid_until->format('d M Y') }}</div>
                                    @if($voucher->valid_until->isPast())
                                        <span class="text-danger" style="font-size:.7rem;">Expired</span>
                                    @else
                                        <span class="text-muted" style="font-size:.7rem;">{{ $voucher->valid_until->diffForHumans() }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">Tanpa Batas</span>
                                @endif
                            </td>
                            <td>
                                @if($voucher->status=='active')
                                    <span class="badge-modern b-success"><i class="bi bi-check-circle"></i> Aktif</span>
                                @else
                                    <span class="badge-modern b-danger"><i class="bi bi-x-circle"></i> Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1"
                                        data-bs-toggle="modal" data-bs-target="#editVoucherModal{{ $voucher->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus voucher ini?');">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Edit Voucher Modal --}}
                        <div class="modal fade" id="editVoucherModal{{ $voucher->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Voucher</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Nama Voucher</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $voucher->name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Kode Promo</label>
                                                    <input type="text" name="code" class="form-control text-uppercase" value="{{ $voucher->code }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Tipe Diskon</label>
                                                    <select name="discount_type" class="form-select">
                                                        <option value="fixed" {{ $voucher->discount_type=='fixed' ? 'selected':'' }}>Nominal (Rp)</option>
                                                        <option value="percent" {{ $voucher->discount_type=='percent' ? 'selected':'' }}>Persentase (%)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label fw-semibold">Besaran Diskon</label>
                                                    <input type="number" name="amount" class="form-control" value="{{ intval($voucher->amount) }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Target</label>
                                                    <select name="target_fee" class="form-select">
                                                        <option value="all" {{ $voucher->target_fee=='all'?'selected':'' }}>Semua Biaya</option>
                                                        <option value="registration" {{ $voucher->target_fee=='registration'?'selected':'' }}>Biaya Pendaftaran</option>
                                                        <option value="ukt" {{ $voucher->target_fee=='ukt'?'selected':'' }}>Biaya UKT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Berlaku S/d</label>
                                                    <input type="date" name="valid_until" class="form-control" value="{{ $voucher->valid_until ? $voucher->valid_until->format('Y-m-d') : '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="active" {{ $voucher->status=='active'?'selected':'' }}>Aktif</option>
                                                        <option value="inactive" {{ $voucher->status=='inactive'?'selected':'' }}>Nonaktif</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Deskripsi</label>
                                                    <textarea name="description" class="form-control" rows="2">{{ $voucher->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-ticket-detailed fs-1 text-muted d-block mb-2 opacity-50"></i>
                                <h6 class="fw-semibold">Belum Ada Voucher</h6>
                                <p class="text-muted small mb-0">Buat voucher diskon untuk para pendaftar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ===== Modal Tambah Gelombang ===== --}}
<div class="modal fade" id="addWaveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Gelombang Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.waves.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Gelombang</label>
                            <input type="text" name="name" class="form-control" placeholder="Cth: Gelombang 1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tahun Akademik</label>
                            <input type="text" name="academic_year" class="form-control" placeholder="2026/2027" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== Modal Tambah Voucher ===== --}}
<div class="modal fade" id="addVoucherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Buat Voucher Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Voucher</label>
                            <input type="text" name="name" class="form-control" placeholder="Cth: Early Bird Gelombang 1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kode Promo</label>
                            <input type="text" name="code" class="form-control text-uppercase" placeholder="Cth: ROSMA2026" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tipe Diskon</label>
                            <select name="discount_type" class="form-select">
                                <option value="fixed">Nominal (Rp)</option>
                                <option value="percent">Persentase (%)</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Besaran Diskon</label>
                            <input type="number" name="amount" class="form-control" placeholder="500000 atau 50" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Target Potongan</label>
                            <select name="target_fee" class="form-select">
                                <option value="all">Semua Biaya</option>
                                <option value="registration">Biaya Pendaftaran</option>
                                <option value="ukt">Biaya UKT/Tahapan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Berlaku S/d</label>
                            <input type="date" name="valid_until" class="form-control">
                            <small class="text-muted mt-1 d-block">Kosongkan = tanpa batas</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi (Opsional)</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Syarat dan ketentuan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Buat Voucher</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
