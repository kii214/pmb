{{-- ===================== PROFIL INSTITUSI & VUE STATS PANEL ===================== --}}
<section class="about-section" id="informasi">
    <div class="container">
        <div class="row align-items-center g-5">

            {{-- SISI KIRI: PROFIL INSTITUSI --}}
            <div class="col-lg-6">
                <div class="section-eyebrow mb-3">
                    <i class="bi bi-bank2 me-2"></i>PROFIL INSTITUSI
                </div>
                <h2 class="about-title">
                    Pusat Pendidikan IT Terpercaya di <span class="about-highlight">Karawang</span>
                </h2>
                <p class="about-desc">
                    STMIK ROSMA berdiri sejak tahun 1990-an dan telah mencetak ribuan tenaga profesional di bidang teknologi informasi. Berlokasi di jantung Kawasan Industri terbesar se-Asia Tenggara, lulusan kami langsung terserap di ratusan perusahaan nasional dan multinasional.
                </p>

                <div class="about-badges mb-4">
                    <div class="about-badge-item">
                        <div class="about-badge-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <strong>LAM-INFOKOM</strong>
                            <span>Terakreditasi Resmi</span>
                        </div>
                    </div>
                    <div class="about-badge-item">
                        <div class="about-badge-icon">
                            <i class="bi bi-buildings"></i>
                        </div>
                        <div>
                            <strong>50+ Mitra</strong>
                            <span>Industri Karawang</span>
                        </div>
                    </div>
                    <div class="about-badge-item">
                        <div class="about-badge-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <div>
                            <strong>30+ Tahun</strong>
                            <span>Pengalaman</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('programs.index') }}" class="btn-about-primary rounded-pill shadow-sm">
                        <i class="bi bi-mortarboard me-2"></i>Program Studi
                    </a>
                    <a href="#jalur" class="btn-about-outline rounded-pill">
                        <i class="bi bi-signpost-2 me-2"></i>Jalur Pendaftaran
                    </a>
                </div>
            </div>

            {{-- SISI KANAN: VUE ANIMATED STATS --}}
            <div class="col-lg-6">
                <div id="campusStatsApp"></div>
            </div>

        </div>
    </div>
</section>
