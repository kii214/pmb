{{-- ===================== JALUR PENDAFTARAN & BEASISWA ===================== --}}
<section class="section-paths" id="jalur">
    <div class="container">
        <div class="text-center mb-5">
            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-primary fw-bold small mb-2">
                <i class="bi bi-signpost-2"></i> JALUR PENDAFTARAN PMB
            </span>
            <h2 class="fw-bold text-dark mt-2" style="font-size:2.2rem; letter-spacing:-0.02em;">Pilihan Jalur Pendaftaran Mahasiswa Baru</h2>
            <p class="text-muted mt-2 mx-auto" style="max-width:620px; font-size:.95rem;">
                STMIK ROSMA membuka pilihan jalur masuk yang fleksibel sesuai kebutuhan Anda, mulai dari lulusan baru SMA/SMK, pekerja profesional, rekognisi pengalaman, hingga beasiswa.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Jalur Reguler -->
            <div class="col-lg-4 col-md-6">
                <div class="jalur-new-card">
                    <div class="jalur-new-icon" style="background:#eff6ff;">
                        <i class="bi bi-mortarboard-fill" style="color:#2563eb;"></i>
                    </div>
                    <h5 class="jalur-new-title">Jalur Reguler</h5>
                    <p class="jalur-new-tag">SMA / SMK / MA / Sederajat</p>
                    <p class="jalur-new-desc">Untuk lulusan baru SMA/SMK sederajat yang ingin kuliah terstruktur dengan fokus praktikum siap kerja di industri.</p>
                    <ul class="jalur-new-list">
                        <li><i class="bi bi-check2"></i> Pilihan jadwal kuliah Pagi & Malam</li>
                        <li><i class="bi bi-check2"></i> Kesempatan Beasiswa KIP & Yayasan</li>
                        <li><i class="bi bi-check2"></i> Kurikulum berbasis praktikum industri</li>
                        <li><i class="bi bi-check2"></i> Penyaluran magang & kerja di Karawang</li>
                    </ul>
                    <a href="{{ route('applications.create', ['registration_path_id' => 1]) }}" class="jalur-new-btn">
                        Daftar Jalur Reguler <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Jalur Ekstensi (Karyawan) -->
            <div class="col-lg-4 col-md-6">
                <div class="jalur-new-card jalur-new-card--featured">
                    <span class="jalur-new-badge">Paling Diminati</span>
                    <div class="jalur-new-icon" style="background:rgba(255,255,255,0.15);">
                        <i class="bi bi-briefcase-fill" style="color:#fff;"></i>
                    </div>
                    <h5 class="jalur-new-title" style="color:#fff;">Jalur Ekstensi (Karyawan)</h5>
                    <p class="jalur-new-tag" style="color:rgba(255,255,255,0.75);">Kelas Karyawan (Sistem Hybrid)</p>
                    <p class="jalur-new-desc" style="color:rgba(255,255,255,0.85);">Kuliah fleksibel tanpa mengorbankan waktu kerja. Pembelajaran Hybrid (Online E-Learning & Tatap Muka Malam/Sabtu).</p>
                    <ul class="jalur-new-list jalur-new-list--light">
                        <li><i class="bi bi-check2"></i> Sistem kuliah Hybrid (Online & Tatap Muka)</li>
                        <li><i class="bi bi-check2"></i> Jadwal kuliah Malam & Sabtu</li>
                        <li><i class="bi bi-check2"></i> Skema cicilan biaya per bulan terjangkau</li>
                        <li><i class="bi bi-check2"></i> Akses Portal E-Learning mandiri 24 jam</li>
                    </ul>
                    <a href="{{ route('applications.create', ['registration_path_id' => 2]) }}" class="jalur-new-btn jalur-new-btn--light">
                        Daftar Jalur Ekstensi <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Jalur RPL -->
            <div class="col-lg-4 col-md-6">
                <div class="jalur-new-card">
                    <div class="jalur-new-icon" style="background:#f0fdf4;">
                        <i class="bi bi-award-fill" style="color:#16a34a;"></i>
                    </div>
                    <h5 class="jalur-new-title">Jalur RPL</h5>
                    <p class="jalur-new-tag">Rekognisi Pembelajaran Lampau</p>
                    <p class="jalur-new-desc">Konversi pengalaman kerja atau studi terdahulu menjadi SKS akademik sehingga waktu kuliah menjadi lebih singkat.</p>
                    <ul class="jalur-new-list">
                        <li><i class="bi bi-check2"></i> Konversi pengalaman kerja jadi SKS resmi</li>
                        <li><i class="bi bi-check2"></i> Melanjutkan sisa studi sebelumnya (pindahan)</li>
                        <li><i class="bi bi-check2"></i> Masa studi wisuda jauh lebih singkat</li>
                        <li><i class="bi bi-check2"></i> Total biaya pendidikan lebih hemat</li>
                    </ul>
                    <a href="{{ route('applications.create', ['registration_path_id' => 3]) }}" class="jalur-new-btn">
                        Daftar Jalur RPL <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- PROGRAM BEASISWA --}}
        <div class="text-center mt-5 mb-4">
            <h3 class="fw-bold text-dark mb-2">Program Beasiswa Tersedia</h3>
            <p class="text-muted">Dukungan beasiswa pendidikan penuh dan keringanan biaya bagi calon mahasiswa berprestasi.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- KIP Kuliah -->
            <div class="col-md-5">
                <div class="beasiswa-card h-100 d-flex flex-column text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-2 bg-primary-subtle text-primary fs-3">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-primary">KIP Kuliah</h5>
                            <small class="text-muted">Program Pemerintah Republik Indonesia</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-4 flex-grow-1" style="line-height:1.6;">
                        Bantuan biaya pendidikan dari Kemdikbudristek RI untuk calon mahasiswa berprestasi yang membutuhkan dukungan finansial. Biaya kuliah ditanggung penuh hingga lulus ditambah uang saku per semester.
                    </p>
                    <div class="d-flex gap-2 mt-auto">
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalKip">
                            Syarat & Ketentuan <i class="bi bi-info-circle ms-1"></i>
                        </button>
                        <a href="{{ route('applications.create', ['registration_path_id' => 4]) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                            Daftar KIP <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Beasiswa YAPEROS -->
            <div class="col-md-5">
                <div class="beasiswa-card h-100 d-flex flex-column text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-2 bg-warning-subtle text-warning-emphasis fs-3">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-warning-emphasis">Beasiswa YAPEROS</h5>
                            <small class="text-muted">Yayasan Pendidikan Rosma</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-4 flex-grow-1" style="line-height:1.6;">
                        Beasiswa apresiasi dari Yayasan Pendidikan Rosma berupa potongan biaya registrasi pendaftaran dan keringanan biaya SPP/UKT bagi lulusan berprestasi akademik maupun non-akademik.
                    </p>
                    <div class="d-flex gap-2 mt-auto">
                        <button class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-semibold text-dark" data-bs-toggle="modal" data-bs-target="#modalYaperos">
                            Syarat & Ketentuan <i class="bi bi-info-circle ms-1"></i>
                        </button>
                        <a href="{{ route('applications.create', ['registration_path_id' => 5]) }}" class="btn btn-sm btn-warning rounded-pill px-3 fw-semibold text-dark">
                            Daftar YAPEROS <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL KIP KULIAH -->
<div class="modal fade" id="modalKip" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-block bg-primary text-white p-5 d-flex flex-column justify-content-center">
                        <i class="bi bi-mortarboard-fill display-4 mb-3"></i>
                        <h3 class="fw-bold mb-2">KIP Kuliah</h3>
                        <p class="text-white-50 mb-0">Program Beasiswa Kemdikbudristek RI untuk Generasi Unggul Indonesia.</p>
                    </div>
                    <div class="col-md-7 p-4 p-md-5 position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4 shadow-none" data-bs-dismiss="modal"></button>
                        <h5 class="fw-bold text-dark mb-3">Manfaat Beasiswa:</h5>
                        <ul class="list-unstyled text-muted small mb-4" style="line-height: 1.8;">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Bebas Biaya Kuliah hingga lulus.</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Bantuan biaya hidup berkala dari pemerintah.</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Prioritas pendampingan akademik dan pengembangan karir.</li>
                        </ul>
                        <div class="p-3 rounded-3 bg-light border mb-4 small text-muted">
                            Kunjungi portal resmi KIP Kuliah untuk panduan sinkronisasi akun PMB STMIK ROSMA.
                        </div>
                        <a href="https://kip-kuliah.kemdikbud.go.id/" target="_blank" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                            Portal Resmi KIP Kuliah <i class="bi bi-box-arrow-up-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL YAPEROS -->
<div class="modal fade" id="modalYaperos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-block bg-warning text-dark p-5 d-flex flex-column justify-content-center">
                        <i class="bi bi-award-fill display-4 mb-3 text-dark"></i>
                        <h3 class="fw-bold mb-2">Beasiswa YAPEROS</h3>
                        <p class="text-dark-50 mb-0">Apresiasi Yayasan Pendidikan Rosma bagi Insan Berprestasi Karawang & sekitarnya.</p>
                    </div>
                    <div class="col-md-7 p-4 p-md-5 position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4 shadow-none" data-bs-dismiss="modal"></button>
                        <h5 class="fw-bold text-dark mb-3">Keuntungan & Syarat:</h5>
                        <ul class="list-unstyled text-muted small mb-4" style="line-height: 1.8;">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Keringanan biaya registrasi awal masuk.</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Potongan cicilan perkuliahan berdasarkan sertifikat prestasi.</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Berlaku untuk pendaftar Sarjana (S1) maupun Diploma (D3).</li>
                        </ul>
                        <a href="{{ route('applications.create', ['registration_path_id' => 5]) }}" class="btn btn-warning w-100 rounded-pill fw-bold py-2 text-dark">
                            Daftar & Ajukan Beasiswa <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
