{{-- ===================== ALUR PENDAFTARAN ===================== --}}
<section class="section-steps" id="tahapan">
    <div class="container text-center">
        <div class="mb-4" data-aos="fade-up">
            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-primary fw-bold small mb-2">
                <i class="bi bi-list-ol"></i> TATA CARA
            </span>
            <h2 class="fw-bold text-dark mt-2" style="font-size:2.2rem; letter-spacing:-0.02em;">Alur Pendaftaran Online</h2>
            <p class="text-muted mt-2 mx-auto" style="max-width:540px; font-size:.95rem;">
                Proses pendaftaran cepat, transparan, dan dapat diselesaikan dari mana saja.
            </p>
        </div>

        <div class="d-flex justify-content-center mb-5">
            <div class="alur-segmented-control" id="alurSelector">
                <button type="button" class="asc-btn active" onclick="switchAlurTab(this, 'alur-reguler')">Jalur Reguler</button>
                <button type="button" class="asc-btn" onclick="switchAlurTab(this, 'alur-ekstensi')">Jalur Ekstensi (Karyawan)</button>
                <button type="button" class="asc-btn" onclick="switchAlurTab(this, 'alur-rpl')">Jalur RPL</button>
            </div>
        </div>

        {{-- Alur Reguler --}}
        <div class="alur-content-box active" id="alur-reguler">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step">
                        <span class="step-number-circle">1</span>
                        <div class="fs-3 text-primary mb-2"><i class="bi bi-globe"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Akses Portal PMB</h6>
                        <p class="text-muted small mb-0">Buka situs resmi pmb.rosma.ac.id dan klik tombol Daftar Sekarang.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step">
                        <span class="step-number-circle">2</span>
                        <div class="fs-3 text-primary mb-2"><i class="bi bi-pencil-square"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Isi Formulir</h6>
                        <p class="text-muted small mb-0">Lengkapi data diri, asal sekolah, dan tentukan Program Studi pilihan Anda.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step">
                        <span class="step-number-circle">3</span>
                        <div class="fs-3 text-primary mb-2"><i class="bi bi-wallet2"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Konfirmasi Pembayaran</h6>
                        <p class="text-muted small mb-0">Selesaikan biaya registrasi pendaftaran dan unggah bukti transfer.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step">
                        <span class="step-number-circle">4</span>
                        <div class="fs-3 text-primary mb-2"><i class="bi bi-person-check-fill"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Verifikasi & Pengumuman</h6>
                        <p class="text-muted small mb-0">Tim PMB memverifikasi berkas dan menerbitkan Nomor Induk Mahasiswa (NIM).</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alur Ekstensi --}}
        <div class="alur-content-box d-none" id="alur-ekstensi">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step border-top border-warning border-3">
                        <span class="step-number-circle bg-warning-subtle text-warning-emphasis">1</span>
                        <div class="fs-3 text-warning mb-2"><i class="bi bi-file-earmark-person"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Daftar Akun Karyawan</h6>
                        <p class="text-muted small mb-0">Pilih program Jalur Ekstensi (Malam/Sabtu) pada formulir online.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step border-top border-warning border-3">
                        <span class="step-number-circle bg-warning-subtle text-warning-emphasis">2</span>
                        <div class="fs-3 text-warning mb-2"><i class="bi bi-briefcase-fill"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Lampirkan Keterangan</h6>
                        <p class="text-muted small mb-0">Unggah salinan identitas diri & surat keterangan bekerja jika ada.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step border-top border-warning border-3">
                        <span class="step-number-circle bg-warning-subtle text-warning-emphasis">3</span>
                        <div class="fs-3 text-warning mb-2"><i class="bi bi-chat-dots-fill"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Konsultasi Jadwal</h6>
                        <p class="text-muted small mb-0">Tim konselor membantu penyesuaian jadwal kuliah dengan shift kerja Anda.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step border-top border-warning border-3">
                        <span class="step-number-circle bg-warning-subtle text-warning-emphasis">4</span>
                        <div class="fs-3 text-warning mb-2"><i class="bi bi-mortarboard-fill"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Mulai Kuliah Hybrid</h6>
                        <p class="text-muted small mb-0">Akses portal E-Learning ROSMA dan ikuti perkuliahan fleksibel.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alur RPL --}}
        <div class="alur-content-box d-none" id="alur-rpl">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step border-top border-success border-3">
                        <span class="step-number-circle bg-success-subtle text-success">1</span>
                        <div class="fs-3 text-success mb-2"><i class="bi bi-folder-check"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Pengajuan Portofolio</h6>
                        <p class="text-muted small mb-0">Daftar online dan siapkan bukti sertifikasi kerja / transkrip nilai lama.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step border-top border-success border-3">
                        <span class="step-number-circle bg-success-subtle text-success">2</span>
                        <div class="fs-3 text-success mb-2"><i class="bi bi-clipboard2-data"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Asesmen Konversi SKS</h6>
                        <p class="text-muted small mb-0">Tim asesor program studi menilai kelayakan portofolio yang diajukan.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step border-top border-success border-3">
                        <span class="step-number-circle bg-success-subtle text-success">3</span>
                        <div class="fs-3 text-success mb-2"><i class="bi bi-check-all"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Penyetaraan Mata Kuliah</h6>
                        <p class="text-muted small mb-0">Menerima penetapan sisa SKS yang wajib ditempuh hingga wisuda.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="alur-card-step border-top border-success border-3">
                        <span class="step-number-circle bg-success-subtle text-success">4</span>
                        <div class="fs-3 text-success mb-2"><i class="bi bi-award"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Wisuda Lebih Cepat</h6>
                        <p class="text-muted small mb-0">Menuntaskan kuliah dengan durasi waktu yang jauh lebih singkat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
