@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Greeting --}}
<div class="mb-5">
    <h3 class="fw-bold mb-1" style="color:#0F172A; font-size:1.5rem;">Selamat datang, {{ Auth::user()->name }} 👋</h3>
    <p class="text-muted mb-0" style="font-size:0.875rem;">{{ now()->isoFormat('dddd, D MMMM YYYY') }} · Berikut ringkasan aktivitas PMB STMIK ROSMA.</p>
</div>

{{-- Stat Cards --}}
<div class="row g-4 mb-5">
    <div class="col-sm-6 col-xl-3">
        <div class="admin-card p-4" style="border-left:4px solid #4F46E5;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.6px;">Total Pendaftar</p>
                    <h2 class="fw-bold mb-0" style="font-size:2.2rem; color:#0F172A;">{{ $applicationCount ?? 0 }}</h2>
                </div>
                <div style="width:46px;height:46px;background:#EEF2FF;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-people-fill" style="color:#4F46E5;font-size:1.3rem;"></i>
                </div>
            </div>
            <p class="mb-0 mt-3" style="font-size:0.75rem;color:#64748B;">Sejak awal pembukaan PMB</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-card p-4" style="border-left:4px solid #F59E0B;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.6px;">Menunggu Verifikasi</p>
                    <h2 class="fw-bold mb-0" style="font-size:2.2rem; color:#0F172A;">{{ $pendingCount ?? 0 }}</h2>
                </div>
                <div style="width:46px;height:46px;background:#FFFBEB;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-hourglass-split" style="color:#F59E0B;font-size:1.3rem;"></i>
                </div>
            </div>
            <a href="{{ route('admin.applicants.index') }}" class="mt-3 d-block" style="font-size:0.75rem;color:#4F46E5;text-decoration:none;font-weight:600;">
                Verifikasi sekarang →
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-card p-4" style="border-left:4px solid #10B981;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.6px;">Program Studi</p>
                    <h2 class="fw-bold mb-0" style="font-size:2.2rem; color:#0F172A;">{{ $programCount ?? 0 }}</h2>
                </div>
                <div style="width:46px;height:46px;background:#ECFDF5;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-mortarboard-fill" style="color:#10B981;font-size:1.3rem;"></i>
                </div>
            </div>
            <a href="{{ route('admin.programs') }}" class="mt-3 d-block" style="font-size:0.75rem;color:#4F46E5;text-decoration:none;font-weight:600;">
                Kelola Prodi →
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-card p-4" style="border-left:4px solid #3B82F6;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.6px;">Diterima</p>
                    <h2 class="fw-bold mb-0" style="font-size:2.2rem; color:#0F172A;">{{ $acceptedCount ?? 0 }}</h2>
                </div>
                <div style="width:46px;height:46px;background:#EFF6FF;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-patch-check-fill" style="color:#3B82F6;font-size:1.3rem;"></i>
                </div>
            </div>
            <p class="mb-0 mt-3" style="font-size:0.75rem;color:#64748B;">Pendaftar yang diterima</p>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row g-4 mb-5">
    <div class="col-lg-7">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <div>
                    <h6 class="admin-card-title">Pendaftar per Program Studi</h6>
                    <p class="text-muted mb-0" style="font-size:0.78rem;">Distribusi seluruh pendaftaran berdasarkan prodi</p>
                </div>
            </div>
            <div class="admin-card-body">
                <canvas id="programChart" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <div>
                    <h6 class="admin-card-title">Status Pendaftaran</h6>
                    <p class="text-muted mb-0" style="font-size:0.78rem;">Sebaran status semua pendaftar</p>
                </div>
            </div>
            <div class="admin-card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="statusChart" style="max-height:220px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Quick Access --}}
<div class="admin-card">
    <div class="admin-card-header">
        <h6 class="admin-card-title">Akses Cepat</h6>
        <p class="text-muted mb-0" style="font-size:0.78rem;">Kelola semua bagian website PMB dari sini</p>
    </div>
    <div class="admin-card-body">
        <div class="row g-3">
            @php
                $shortcuts = [
                    ['route' => 'admin.applicants.index', 'icon' => 'bi-people-fill',       'color' => '#4F46E5', 'bg' => '#EEF2FF', 'label' => 'Kelola Pendaftar',   'desc' => 'Verifikasi & kelola CAMABA'],
                    ['route' => 'admin.fees',             'icon' => 'bi-wallet2',            'color' => '#10B981', 'bg' => '#ECFDF5', 'label' => 'Biaya Kuliah',       'desc' => 'Atur harga & komponen biaya'],
                    ['route' => 'admin.settings',         'icon' => 'bi-bank2',              'color' => '#F59E0B', 'bg' => '#FFFBEB', 'label' => 'Rekening & Kontak',  'desc' => 'Setting transfer & WA'],
                    ['route' => 'admin.banners.index',    'icon' => 'bi-images',             'color' => '#3B82F6', 'bg' => '#EFF6FF', 'label' => 'Banners Carousel',   'desc' => 'Kelola slide halaman utama'],
                    ['route' => 'admin.news',             'icon' => 'bi-newspaper',          'color' => '#8B5CF6', 'bg' => '#F5F3FF', 'label' => 'Berita',             'desc' => 'Tambah & edit pengumuman'],
                    ['route' => 'admin.programs',         'icon' => 'bi-mortarboard',        'color' => '#EC4899', 'bg' => '#FDF2F8', 'label' => 'Program Studi',      'desc' => 'Data prodi & akreditasi'],
                ]
            @endphp
            @foreach($shortcuts as $sc)
            <div class="col-md-4 col-sm-6">
                <a href="{{ route($sc['route']) }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
                   style="background:#FAFBFD; border:1.5px solid #E2E8F0; transition:all 0.15s;"
                   onmouseover="this.style.borderColor='{{ $sc['color'] }}';this.style.background='#F8FAFF';"
                   onmouseout="this.style.borderColor='#E2E8F0';this.style.background='#FAFBFD';">
                    <div style="width:42px;height:42px;background:{{ $sc['bg'] }};border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi {{ $sc['icon'] }}" style="color:{{ $sc['color'] }};font-size:1.15rem;"></i>
                    </div>
                    <div>
                        <p class="fw-semibold mb-0" style="font-size:0.875rem;color:#0F172A;">{{ $sc['label'] }}</p>
                        <p class="mb-0" style="font-size:0.75rem;color:#94A3B8;">{{ $sc['desc'] }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const rawProgramStats = @json($programStats ?? []);
    const rawStatusStats  = @json($statusStats ?? []);

    // Chart 1: Bar (Program Studi)
    const progLabels = rawProgramStats.map(i => i.name);
    const progData   = rawProgramStats.map(i => i.count);
    const colors     = ['#4F46E5','#7C3AED','#2563EB','#0891B2'];

    new Chart(document.getElementById('programChart'), {
        type: 'bar',
        data: {
            labels: progLabels.length ? progLabels : ['Belum ada data'],
            datasets: [{
                label: 'Pendaftar',
                data: progData.length ? progData : [0],
                backgroundColor: colors,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} pendaftar`
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 12 } } },
                y: { beginAtZero: true, ticks: { precision: 0, font: { size: 12 } }, grid: { color: '#F1F5F9' } }
            }
        }
    });

    // Chart 2: Doughnut (Status)
    const statusMap = {
        'draft':     { label: 'Draft',       color: '#E2E8F0' },
        'submitted': { label: 'Menunggu',    color: '#FCD34D' },
        'verified':  { label: 'Diverifikasi',color: '#60A5FA' },
        'accepted':  { label: 'Diterima',    color: '#34D399' },
        'rejected':  { label: 'Ditolak',     color: '#F87171' }
    };

    let sLabels = [], sData = [], sColors = [];
    Object.keys(rawStatusStats).forEach(key => {
        sLabels.push(statusMap[key]?.label ?? key);
        sData.push(rawStatusStats[key]);
        sColors.push(statusMap[key]?.color ?? '#94A3B8');
    });

    if (!sData.length) { sLabels = ['Kosong']; sData = [1]; sColors = ['#F1F5F9']; }

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: sLabels,
            datasets: [{ data: sData, backgroundColor: sColors, borderWidth: 3, borderColor: '#ffffff' }]
        },
        options: {
            responsive: true,
            cutout: '68%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } }
            }
        }
    });
});
</script>
@endpush
