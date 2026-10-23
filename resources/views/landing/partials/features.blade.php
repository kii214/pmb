{{-- ===================== 4 PILAR KEUNGGULAN & MITRA ===================== --}}
<section class="section-features" id="keunggulan">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="50">
                <div class="feature-pillar-card h-100 p-4 rounded-4 shadow-sm">
                    <div class="pillar-icon bg-primary-subtle text-primary mb-3">
                        <i class="bi bi-code-slash fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size:1.05rem;">Kurikulum Terapan</h5>
                    <p class="text-muted small mb-0" style="line-height:1.6;">
                        Fokus pada keahlian praktis Software Engineering, Web, Mobile, Data, dan Jaringan yang langsung terpakai di tempat kerja.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-pillar-card h-100 p-4 rounded-4 shadow-sm">
                    <div class="pillar-icon bg-success-subtle text-success mb-3">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size:1.05rem;">Kelas Karyawan (Malam/Sabtu)</h5>
                    <p class="text-muted small mb-0" style="line-height:1.6;">
                        Jadwal perkuliahan fleksibel untuk pekerja profesional tanpa mengganggu jam kerja di industri.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                <div class="feature-pillar-card h-100 p-4 rounded-4 shadow-sm">
                    <div class="pillar-icon bg-warning-subtle text-warning mb-3">
                        <i class="bi bi-cash-coin fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size:1.05rem;">Cicilan Biaya Terjangkau</h5>
                    <p class="text-muted small mb-0" style="line-height:1.6;">
                        Biaya kuliah dapat diangsur setiap bulan dengan skema transparan tanpa ada biaya tersembunyi.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-pillar-card h-100 p-4 rounded-4 shadow-sm">
                    <div class="pillar-icon bg-info-subtle text-info mb-3">
                        <i class="bi bi-briefcase fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size:1.05rem;">Jejaring Karir Industri</h5>
                    <p class="text-muted small mb-0" style="line-height:1.6;">
                        Kerja sama penyaluran kerja dan magang dengan puluhan perusahaan terkemuka di kawasan industri Karawang.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MITRA INDUSTRI / PARTNERS --}}
@if(isset($partners) && count($partners) > 0)
<section class="partners-section">
    <div class="container">
        <p class="partners-label">Diakui & Bermitra Dengan Puluhan Perusahaan Industri</p>
        <div class="partners-row">
            @foreach($partners as $partner)
                <div class="partner-item">
                    @if($partner->image)
                        <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}">
                    @else
                        <span class="fw-bold text-secondary text-uppercase small">{{ $partner->name }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
