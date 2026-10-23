@extends('layouts.admin')

@section('title', $wave->name . ' – Pilih Jurusan')

@push('styles')
<style>
    .prodi-card {
        border: none;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.04);
        transition: transform .18s, box-shadow .18s;
        overflow: hidden;
        height: 100%;
        text-decoration: none;
        display: block;
        color: inherit;
    }
    .prodi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(79,70,229,.15);
        color: inherit;
    }
    .prodi-card-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .prodi-arrow {
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #f1f5f9; color: #94a3b8;
        transition: all .18s; font-size: .9rem;
    }
    .prodi-card:hover .prodi-arrow {
        background: #4f46e5; color: #fff;
    }
    .badge-modern {
        padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: .7rem;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .b-success { background:#dcfce7; color:#16a34a; }
    .b-primary { background:#e0e7ff; color:#4f46e5; }
    .b-muted   { background:#f1f5f9; color:#64748b; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb" style="font-size:.85rem;">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.fees') }}" class="text-decoration-none text-muted">Biaya & Voucher</a>
        </li>
        <li class="breadcrumb-item active text-dark fw-semibold">{{ $wave->name }}</li>
    </ol>
</nav>

{{-- Header --}}
<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-5">
    <div>
        <h3 class="fw-bold mb-2 text-dark">{{ $wave->name }}</h3>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="text-muted" style="font-size:.85rem;">
                <i class="bi bi-calendar-range text-primary me-1"></i>
                {{ $wave->start_date->format('d M Y') }} &rarr; {{ $wave->end_date->format('d M Y') }}
            </span>
            <span class="text-muted" style="font-size:.85rem;">
                <i class="bi bi-mortarboard text-primary me-1"></i> T.A. {{ $wave->academic_year }}
            </span>
        </div>
        <p class="text-muted mt-2 mb-0" style="font-size:.85rem;">Pilih program studi untuk mengatur rincian biayanya.</p>
    </div>
    <a href="{{ route('admin.fees') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

{{-- Program Study Cards --}}
@php
    $iconMap = ['bi-cpu-fill','bi-diagram-3-fill','bi-database-fill-gear','bi-hdd-network-fill','bi-grid-1x2-fill','bi-layers-fill'];
    $colorMap = ['#4f46e5','#0ea5e9','#10b981','#f59e0b','#ef4444','#8b5cf6'];
@endphp

<div class="row g-4">
    @foreach($programs as $i => $program)
    @php
        $color = $colorMap[$i % count($colorMap)];
        $icon  = $iconMap[$i % count($iconMap)];
    @endphp
    <div class="col-md-6 col-xl-4">
        <a href="{{ route('admin.fees.program', [$wave->id, $program->id]) }}" class="prodi-card">
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="prodi-card-icon" style="background:{{ $color }}1a; color:{{ $color }};">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark" style="font-size:.95rem; line-height:1.3;">{{ $program->name }}</div>
                        <div class="text-muted" style="font-size:.78rem;">{{ $program->level ?? 'S1' }}</div>
                    </div>
                    <div class="prodi-arrow"><i class="bi bi-chevron-right"></i></div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    @if($program->fee_count > 0)
                        <span class="badge-modern b-success">
                            <i class="bi bi-check-circle-fill"></i> {{ $program->fee_count }} Komponen
                        </span>
                    @else
                        <span class="badge-modern b-muted">
                            <i class="bi bi-dash-circle"></i> Belum diisi
                        </span>
                    @endif
                    <span class="text-muted" style="font-size:.75rem;">Klik untuk atur &rarr;</span>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@endsection
