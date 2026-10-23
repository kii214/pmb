@extends('layouts.admin')

@section('title', 'Kelola Pendaftar')

@push('styles')
<style>
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        border-color: #cbd5e1;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .stat-blue { background: #eff6ff; color: #3b82f6; }
    .stat-orange { background: #fff7ed; color: #f97316; }
    .stat-cyan { background: #ecfeff; color: #06b6d4; }
    .stat-green { background: #f0fdf4; color: #22c55e; }
    .stat-red { background: #fef2f2; color: #ef4444; }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .stat-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #64748b;
    }

    .filter-wrapper {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
    }
    .filter-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }
    
    .table-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
    }
    
    .table-modern {
        margin-bottom: 0;
    }
    .table-modern thead th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 20px;
    }
    .table-modern tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
        color: #334155;
    }
    .table-modern tbody tr:last-child td { border-bottom: none; }
    .table-modern tbody tr:hover td { background: #f8fafc; }

    .avatar-modern {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .avatar-purple { background: #f3e8ff; color: #9333ea; }
    
    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .b-warning { background: #fef3c7; color: #d97706; }
    .b-info { background: #e0f2fe; color: #0284c7; }
    .b-success { background: #dcfce7; color: #16a34a; }
    .b-danger { background: #fee2e2; color: #dc2626; }
    .b-secondary { background: #f1f5f9; color: #475569; }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #64748b;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-action:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1 text-dark"><i class="bi bi-mortarboard-fill text-primary me-2"></i>Data CAMABA</h3>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Pantau dan kelola pendaftaran mahasiswa baru secara real-time.</p>
    </div>
    <a href="{{ route('admin.applicants.export', request()->query()) }}" class="btn btn-success d-flex align-items-center gap-2 px-4 rounded-3 shadow-sm fw-semibold" style="background: #107c41; border-color: #107c41;">
        <i class="bi bi-file-earmark-excel-fill"></i> Unduh Laporan Excel
    </a>
</div>

{{-- STATS --}}
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl">
        <div class="stat-card h-100">
            <div class="stat-icon stat-blue"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Pendaftar</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl">
        <div class="stat-card h-100">
            <div class="stat-icon stat-orange"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-value">{{ $stats['submitted'] }}</div>
                <div class="stat-label">Menunggu Review</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl">
        <div class="stat-card h-100">
            <div class="stat-icon stat-cyan"><i class="bi bi-shield-check"></i></div>
            <div>
                <div class="stat-value">{{ $stats['verified'] }}</div>
                <div class="stat-label">Diverifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl">
        <div class="stat-card h-100">
            <div class="stat-icon stat-green"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-value">{{ $stats['accepted'] }}</div>
                <div class="stat-label">Diterima</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl">
        <div class="stat-card h-100">
            <div class="stat-icon stat-red"><i class="bi bi-x-circle-fill"></i></div>
            <div>
                <div class="stat-value">{{ $stats['rejected'] }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
    </div>
</div>

{{-- FILTER --}}
<div class="filter-wrapper">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="filter-label"><i class="bi bi-search me-1"></i> Pencarian Data</label>
            <input type="text" name="search" class="form-control" style="border-radius: 8px; padding: 10px 15px;" placeholder="Ketik nama, email, atau nomor pendaftaran..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <label class="filter-label">Status</label>
            <select name="status" class="form-select" style="border-radius: 8px; padding: 10px 15px;">
                <option value="">Semua</option>
                <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Diverifikasi</option>
                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="filter-label">Program Studi</label>
            <select name="prodi" class="form-select" style="border-radius: 8px; padding: 10px 15px;">
                <option value="">Semua Prodi</option>
                @foreach($programs as $p)
                    <option value="{{ $p->id }}" {{ request('prodi') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">Jalur Masuk</label>
            <select name="jalur" class="form-select" style="border-radius: 8px; padding: 10px 15px;">
                <option value="">Semua Jalur</option>
                @foreach($paths as $p)
                    <option value="{{ $p->id }}" {{ request('jalur') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-center" style="border-radius: 8px; padding: 10px;">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
</div>

{{-- TABLE --}}
<div class="table-card mb-4">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="background: #fff;">
        <div class="fw-semibold text-dark"><i class="bi bi-person-lines-fill text-primary me-2"></i>Direktori Pendaftar</div>
        <div class="badge bg-light text-dark border">{{ $applications->total() }} kandidat ditemukan</div>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th class="text-center" width="50">#</th>
                    <th>Pendaftar</th>
                    <th>Program Studi & Jalur</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    @php $fd = $app->form_data ?? []; @endphp
                    <tr>
                        <td class="text-center text-muted">{{ $applications->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-modern avatar-purple">
                                    {{ strtoupper(substr($fd['full_name'] ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-1">{{ $fd['full_name'] ?? 'Belum ada nama' }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem; font-family: monospace;">
                                        #{{ $app->application_number }} &bull; {{ $fd['email'] ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark mb-1" style="font-size: 0.85rem;">{{ $app->programStudy?->name ?? '-' }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Jalur: {{ $app->registrationPath?->name ?? '-' }}</div>
                        </td>
                        <td>
                            @php
                                $statusMap = [
                                    'submitted'  => ['b-warning', '<i class="bi bi-hourglass-split me-1"></i>Menunggu'],
                                    'verified'   => ['b-info', '<i class="bi bi-shield-check me-1"></i>Diverifikasi'],
                                    'accepted'   => ['b-success', '<i class="bi bi-check-circle-fill me-1"></i>Diterima'],
                                    'rejected'   => ['b-danger', '<i class="bi bi-x-circle-fill me-1"></i>Ditolak'],
                                    'waitlisted' => ['b-secondary', '<i class="bi bi-card-list me-1"></i>Waitlist'],
                                ];
                                $s = $statusMap[$app->status] ?? ['b-secondary', $app->status];
                            @endphp
                            <span class="badge-modern {{ $s[0] }}">{!! $s[1] !!}</span>
                        </td>
                        <td>
                            <div class="text-dark fw-medium" style="font-size: 0.85rem;">{{ $app->created_at->format('d M Y') }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $app->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.applicants.show', $app) }}" class="btn-action" title="Lihat Detail">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted mb-3" style="font-size: 3rem;"><i class="bi bi-inbox"></i></div>
                            <h6 class="text-dark fw-semibold">Tidak ada data pendaftar</h6>
                            <p class="text-muted small mb-0">Coba ubah kata kunci pencarian atau filter Anda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($applications->hasPages())
        <div class="p-3 border-top" style="background: #fff;">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
