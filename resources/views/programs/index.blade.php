@extends('layouts.public')

@section('title', 'Program Studi - PMB STMIK ROSMA')

@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="row py-5 align-items-center">
                <div class="col-lg-8">
                    <span class="eyebrow">Program Studi</span>
                    <h1>Jelajahi pilihan studi yang sesuai dengan masa depan Anda.</h1>
                </div>
            </div>
        </div>
    </section>

    {{-- Kartu Program Studi --}}
    <section class="section-block">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                @foreach($programs as $program)
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="program-card h-100 d-flex flex-column">
                            <h4 class="fw-bold mb-2" style="font-size:1.1rem; color:#0F172A;">{{ $program->name }}</h4>
                            <p class="text-muted mb-3" style="font-size:0.875rem; line-height:1.65; flex:1;">{{ Str::limit($program->description, 110) }}</p>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span style="font-size:0.73rem; font-weight:700; padding:3px 10px; border-radius:20px;
                                    {{ $program->level == 'S1' ? 'background:#EEF2FF; color:#4F46E5;' : 'background:#FFF7ED; color:#C2410C;' }}">
                                    {{ $program->level == 'S1' ? 'Sarjana (S1)' : 'Diploma (D3)' }}
                                </span>
                                @if($program->accreditation)
                                <span style="font-size:0.73rem; font-weight:700; padding:3px 10px; border-radius:20px;
                                    {{ str_contains($program->accreditation, 'Baik Sekali') ? 'background:#ECFDF5; color:#065F46;' : (str_contains($program->accreditation, 'Baik') ? 'background:#EFF6FF; color:#1E40AF;' : 'background:#FEF3C7; color:#92400E;') }}">
                                    {{ $program->accreditation }}
                                </span>
                                @endif
                            </div>
                            <a href="{{ route('programs.show', $program->slug) }}"
                               class="btn btn-primary rounded-pill px-4 fw-semibold mt-auto"
                               style="font-size:0.875rem;">
                                Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Tabel Akreditasi Resmi --}}
    <section class="section-block" style="background:#F8FAFC; border-top:1px solid #E2E8F0;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-label" style="font-size:0.75rem; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#4F46E5;">Legalitas & Akreditasi</span>
                <h2 class="fw-bold mt-2 mb-2" style="font-size:1.8rem; color:#0F172A;">Data Akreditasi Program Studi</h2>
                <p class="text-muted" style="max-width:580px; margin:0 auto;">Seluruh program studi STMIK Rosma telah terakreditasi oleh LAM-INFOKOM sebagai lembaga akreditasi mandiri di bidang informatika dan komputer.</p>
            </div>

            <div style="border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.07); border:1px solid #E2E8F0; background:white;">
                <div class="table-responsive">
                    <table style="width:100%; border-collapse:collapse; min-width:700px;">
                        <thead>
                            <tr style="background:#0F172A;">
                                <th style="padding:13px 16px; text-align:center; font-size:0.72rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; width:44px;">No</th>
                                <th style="padding:13px 16px; font-size:0.72rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px;">Program Studi</th>
                                <th style="padding:13px 16px; text-align:center; font-size:0.72rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; white-space:nowrap;">Jenjang</th>
                                <th style="padding:13px 16px; font-size:0.72rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px;">No. SK</th>
                                <th style="padding:13px 16px; text-align:center; font-size:0.72rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; white-space:nowrap;">Peringkat</th>
                                <th style="padding:13px 16px; text-align:center; font-size:0.72rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; white-space:nowrap;">Masa Berlaku</th>
                                <th style="padding:13px 16px; text-align:center; font-size:0.72rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; white-space:nowrap;">Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programs as $program)
                            <tr style="border-bottom:1px solid #F1F5F9; background:{{ $loop->even ? '#FAFBFD' : 'white' }}; transition:background 0.15s;" onmouseover="this.style.background='#F0F4FF'" onmouseout="this.style.background='{{ $loop->even ? '#FAFBFD' : 'white' }}'">
                                {{-- No --}}
                                <td style="padding:16px; text-align:center; font-weight:700; color:#CBD5E1; font-size:0.85rem;">{{ $loop->iteration }}</td>

                                {{-- Nama Prodi --}}
                                <td style="padding:16px;">
                                    <div style="font-weight:700; color:#0F172A; font-size:0.9rem; line-height:1.3;">{{ $program->name }}</div>

                                </td>

                                {{-- Jenjang --}}
                                <td style="padding:16px; text-align:center;">
                                    <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:0.73rem; font-weight:700; white-space:nowrap;
                                        {{ $program->level == 'S1' ? 'background:#EEF2FF; color:#4F46E5;' : 'background:#FFF7ED; color:#C2410C;' }}">
                                        {{ $program->level == 'S1' ? 'S1' : 'D3' }}
                                    </span>
                                </td>

                                {{-- No. SK --}}
                                <td style="padding:16px; font-size:0.8rem; color:#475569; line-height:1.5;">
                                    @if($program->accreditation_sk_number)
                                        <div style="font-weight:500;">{{ $program->accreditation_sk_number }}</div>
                                        @if($program->accreditation_year)
                                        <div style="font-size:0.72rem; color:#94A3B8; margin-top:2px;">Tahun {{ $program->accreditation_year }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- Peringkat --}}
                                <td style="padding:16px; text-align:center;">
                                    @php
                                        $rankColor = match(true) {
                                            str_contains($program->accreditation ?? '', 'Baik Sekali') => ['bg'=>'#ECFDF5','color'=>'#065F46','dot'=>'#10B981'],
                                            str_contains($program->accreditation ?? '', 'Baik')        => ['bg'=>'#EFF6FF','color'=>'#1E40AF','dot'=>'#3B82F6'],
                                            str_contains($program->accreditation ?? '', 'C')           => ['bg'=>'#FEF3C7','color'=>'#92400E','dot'=>'#F59E0B'],
                                            default                                                    => ['bg'=>'#F1F5F9','color'=>'#475569','dot'=>'#94A3B8'],
                                        };
                                    @endphp
                                    <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:0.73rem; font-weight:700; background:{{ $rankColor['bg'] }}; color:{{ $rankColor['color'] }}; white-space:nowrap;">
                                        <span style="width:6px; height:6px; border-radius:50%; background:{{ $rankColor['dot'] }}; flex-shrink:0; display:inline-block;"></span>
                                        {{ $program->accreditation ?? '-' }}
                                    </span>
                                </td>

                                {{-- Masa Berlaku --}}
                                <td style="padding:16px; text-align:center;">
                                    @if($program->accreditation_valid_from && $program->accreditation_valid_until)
                                        <div style="font-size:0.78rem; color:#475569; line-height:1.6;">
                                            <div style="font-weight:500;">{{ $program->accreditation_valid_from->format('d M Y') }}</div>
                                            <div style="color:#94A3B8; font-size:0.7rem; margin:1px 0;">s.d.</div>
                                            <div style="font-weight:600; color:#0F172A;">{{ $program->accreditation_valid_until->format('d M Y') }}</div>
                                        </div>
                                    @else
                                        <span style="color:#CBD5E1; font-size:0.78rem;">-</span>
                                    @endif
                                </td>

                                {{-- Sertifikat --}}
                                <td style="padding:16px; text-align:center;">
                                    @if($program->accreditation_certificate_url)
                                        <a href="{{ $program->accreditation_certificate_url }}" target="_blank"
                                           style="display:inline-flex; align-items:center; gap:5px; padding:6px 14px; border-radius:8px; background:#4F46E5; color:white; font-size:0.73rem; font-weight:700; text-decoration:none; white-space:nowrap; transition:all 0.15s;"
                                           onmouseover="this.style.background='#3730A3'" onmouseout="this.style.background='#4F46E5'">
                                            <i class="bi bi-file-earmark-pdf-fill"></i> Unduh
                                        </a>
                                    @else
                                        <span style="font-size:0.73rem; color:#CBD5E1; font-style:italic;">Segera</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="padding:12px 20px; background:#F8FAFC; border-top:1px solid #E2E8F0; display:flex; align-items:center; gap:8px;">
                    <i class="bi bi-shield-check" style="color:#4F46E5; font-size:0.9rem;"></i>
                    <span style="font-size:0.78rem; color:#64748B;">Diakreditasi oleh <strong>LAM-INFOKOM</strong> — Lembaga Akreditasi Mandiri Informatika dan Komputer</span>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection
