{{-- ===================== JADWAL GELOMBANG PENDAFTARAN ===================== --}}
<section class="section-waves" id="gelombang">
    <div class="container py-2">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-primary fw-bold small mb-2">
                <i class="bi bi-calendar3"></i> JADWAL PMB {{ now()->year }}/{{ now()->year+1 }}
            </span>
            <h2 class="fw-bold text-dark mt-2" style="font-size:2.2rem; letter-spacing:-0.02em;">Gelombang Pendaftaran</h2>
            <p class="text-muted mt-2 mx-auto" style="max-width:560px; font-size:.95rem;">
                Daftarkan diri Anda lebih awal untuk mendapatkan kemudahan proses seleksi dan kuota beasiswa prioritas.
            </p>
        </div>

        <div class="row g-4 justify-content-center" data-aos="fade-up" data-aos-delay="100">
            @foreach($waves as $wave)
            @php
                $isCurrent = $wave->is_current || ($currentWave && $currentWave->id === $wave->id);
            @endphp
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 rounded-4 border {{ $isCurrent ? 'wave-card-active' : 'shadow-sm' }} bg-white overflow-hidden position-relative">
                    <div class="text-center py-1.5 fw-bold small {{ $isCurrent ? 'bg-primary text-white' : 'bg-light text-muted border-bottom' }}" style="font-size:0.75rem; letter-spacing:0.5px;">
                        @if($isCurrent)
                            <i class="bi bi-star-fill text-warning me-1"></i> SEDANG DIBUKA SAAT INI
                        @else
                            <i class="bi bi-clock-history me-1"></i> AKAN DATANG
                        @endif
                    </div>
                    <div class="p-4 d-flex flex-column h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0" style="font-size:1.25rem;">{{ $wave->name }}</h5>
                            @if($isCurrent)
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-1 rounded-pill fw-normal">Akan Datang</span>
                            @endif
                        </div>

                        <div class="p-3 rounded-3 bg-light border mb-4">
                            <div class="d-flex align-items-center gap-2 text-muted mb-2 small">
                                <i class="bi bi-calendar-event text-primary"></i>
                                <span>Periode Pendaftaran:</span>
                            </div>
                            <div class="fw-bold text-dark" style="font-size:0.95rem;">
                                {{ optional($wave->start_date)->format('d M Y') ?? 'TBA' }} &mdash; {{ optional($wave->end_date)->format('d M Y') ?? 'TBA' }}
                            </div>
                        </div>

                        <p class="text-muted small mb-4 flex-grow-1" style="line-height:1.6;">
                            {{ $wave->description ?: 'Pendaftaran calon mahasiswa baru untuk seluruh program studi Diploma (D3) dan Sarjana (S1).' }}
                        </p>

                        <div class="mt-auto">
                            @if($isCurrent)
                                <a href="{{ route('applications.create') }}" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                                    Daftar di Gelombang Ini <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            @else
                                <button class="btn btn-light border text-muted w-100 rounded-pill py-2 fw-semibold" disabled>
                                    Segera Dibuka
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
