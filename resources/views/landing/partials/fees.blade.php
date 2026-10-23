{{-- ===================== BIAYA PENDIDIKAN & SIMULASI ===================== --}}
<section class="section-fees" id="biaya">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-primary fw-bold small mb-2">
                    <i class="bi bi-wallet2"></i> BIAYA PENDIDIKAN
                </span>
                <h2 class="fw-bold text-dark mt-2 mb-3" style="font-size:2.2rem; letter-spacing:-0.02em;">Biaya Terjangkau & Transparan</h2>
                <p class="text-muted lead fs-6 mb-4" style="line-height:1.7;">
                    STMIK ROSMA memberikan kemudahan pembiayaan perkuliahan yang transparan tanpa ada pungutan liar atau biaya tersembunyi.
                </p>
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <span class="text-dark fw-medium">Sistem cicilan bulanan yang fleksibel dan ramah bagi mahasiswa & karyawan.</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <span class="text-dark fw-medium">Potongan biaya khusus untuk pendaftar gelombang awal dan jalur prestasi.</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <span class="text-dark fw-medium">Bebas biaya gedung dengan skema pembiayaan terpadu.</span>
                    </div>
                </div>
                <a href="{{ route('fees.index') }}" class="btn btn-primary px-4 py-3 rounded-pill fw-bold shadow-sm">
                    <i class="bi bi-table me-2"></i>Lihat Tabel Rincian Biaya Lengkap
                </a>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="fee-card">
                    <h5 class="fc-title">Simulasi Biaya Masuk Awal</h5>
                    @php
                        $feeWaveName = ($currentWave ?? $activeWave)?->name ?? 'Gelombang Aktif';
                    @endphp
                    <p class="fc-sub">
                        {{ $defaultProgram->name ?? 'Teknik Informatika (S1)' }} &mdash;
                        <span class="text-primary fw-bold">{{ $feeWaveName }}</span>
                    </p>
                    <div class="fc-rows">
                        @if(isset($simulationFees) && $simulationFees->count() > 0)
                            @foreach($simulationFees as $f)
                                <div class="fc-row">
                                    <span>{{ $f->name }}</span>
                                    <strong>Rp {{ number_format($f->amount, 0, ',', '.') }}</strong>
                                </div>
                            @endforeach
                        @else
                            <div class="fc-row">
                                <span>Biaya Formulir & Registrasi Awal</span>
                                <strong>Rp 1.500.000</strong>
                            </div>
                            <div class="fc-row">
                                <span>SPP Tahap 1</span>
                                <strong>Rp 2.500.000</strong>
                            </div>
                            <div class="fc-row">
                                <span>Biaya Jas Almamater & Orientasi (PKKMB)</span>
                                <strong>Rp 1.000.000</strong>
                            </div>
                        @endif
                    </div>
                    <div class="fc-total">
                        <span>Estimasi Total Pembayaran Awal</span>
                        <strong>Rp {{ number_format(isset($simulationFees) && $simulationFees->count() > 0 ? $simulationFees->sum('amount') : 5000000, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
