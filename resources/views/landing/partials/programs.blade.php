{{-- ===================== PROGRAM STUDI ===================== --}}
<section class="section-prodi" id="prodi">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-primary-subtle text-primary fw-bold small mb-2">
                <i class="bi bi-mortarboard-fill"></i> PROGRAM SARJANA & DIPLOMA
            </span>
            <h2 class="fw-bold text-dark mt-2" style="font-size:2.2rem; letter-spacing:-0.02em;">Program Studi Unggulan</h2>
            <p class="text-muted mt-2 mx-auto" style="max-width:580px; font-size:.95rem;">
                Seluruh program studi telah terakreditasi resmi oleh Lembaga Akreditasi Mandiri Informatika dan Komputer (LAM-INFOKOM).
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($programs as $index => $program)
            @php
                $iconMap  = ['bi-code-square','bi-diagram-3-fill','bi-laptop-fill','bi-calculator-fill'];
                $ic = $iconMap[$index % count($iconMap)];
                $accrLabel = $program->accreditation ?? 'Baik';
                if (strtolower($accrLabel) === 'c') $accrLabel = 'Baik';
                $accrClass = match(strtolower($accrLabel)) {
                    'baik sekali' => 'prodi-accr-baiksekali',
                    'baik'        => 'prodi-accr-baik',
                    default       => 'prodi-accr-baik',
                };
                $validYear = $program->accreditation_valid_until ? $program->accreditation_valid_until->format('Y') : '2028';
            @endphp
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="prodi-card-univ h-100 d-flex flex-column bg-white position-relative">
                    {{-- Header Top: Degree Badge & Accreditation --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge px-3 py-1.5 fw-semibold rounded-pill" style="font-size:0.72rem; background:{{ $program->level == 'S1' ? '#1a4480' : '#c8940a' }}; color:#fff;">
                            {{ $program->level == 'S1' ? 'Sarjana (S1)' : 'Diploma (D3)' }}
                        </span>
                        <span class="prodi-accr-pill {{ $accrClass }}">
                            <i class="bi bi-patch-check-fill me-1"></i>{{ $accrLabel }}
                        </span>
                    </div>

                    {{-- Icon & Program Name --}}
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="prodi-icon-box rounded-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px; background:#e8f0fe; color:#1a4480; font-size:1.35rem; flex-shrink:0;">
                            <i class="bi {{ $ic }}"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0" style="font-size:1.06rem; line-height:1.3;">{{ $program->name }}</h5>
                        </div>
                    </div>

                    {{-- Description --}}
                    <p class="text-muted flex-grow-1 mb-3" style="font-size:0.875rem; line-height:1.6; min-height: 48px;">
                        {{ Str::limit($program->description, 110) }}
                    </p>

                    {{-- Info SK Akreditasi (Uniform & Elegant) --}}
                    <div class="prodi-legal-box mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="d-inline-flex align-items-center gap-1 text-muted" style="font-size:0.73rem; font-weight:600;">
                                <i class="bi bi-patch-check-fill text-success"></i> LAM-INFOKOM
                            </span>
                            <span class="prodi-expiry-badge">
                                Berlaku s.d. {{ $validYear }}
                            </span>
                        </div>
                        <div class="prodi-sk-row d-flex align-items-center text-truncate" title="{{ $program->accreditation_sk_number }}">
                            <span class="text-muted me-1" style="font-size:0.71rem;">No. SK:</span>
                            <span class="text-dark fw-semibold text-truncate" style="font-size:0.72rem; font-family:var(--bs-font-monospace, monospace);">
                                {{ $program->accreditation_sk_number ?: 'Terdaftar Resmi' }}
                            </span>
                        </div>
                    </div>

                    {{-- Dual Action Buttons --}}
                    <div class="pt-3 border-top d-flex align-items-center gap-2 mt-auto">
                        <a href="{{ route('programs.show', $program->slug) }}" class="btn btn-sm btn-outline-secondary prodi-btn-outline flex-grow-1 rounded-pill fw-semibold py-2">
                            <i class="bi bi-book me-1"></i>Kurikulum
                        </a>
                        <a href="{{ route('applications.create', ['program_study_id' => $program->id]) }}" class="btn btn-sm btn-primary prodi-btn-primary flex-grow-1 rounded-pill fw-bold py-2 shadow-sm text-nowrap">
                            Daftar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('programs.index') }}" class="btn btn-light border px-4 py-2 rounded-pill fw-bold text-dark shadow-sm">
                <i class="bi bi-table me-2 text-primary"></i>Lihat Tabel Akreditasi Lengkap Semua Prodi
            </a>
        </div>
    </div>
</section>
