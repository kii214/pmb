@extends('layouts.public')

@section('title', $program->name . ' - PMB STMIK ROSMA')

@section('content')
<!-- Hero Section for Program -->
<div class="program-hero position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary) 0%, #0a1535 100%); padding: 120px 0 80px;">
    <!-- Abstract Shapes -->
    <div class="position-absolute top-0 end-0" style="width: 400px; height: 400px; background: radial-gradient(circle, rgba(37,99,235,0.15) 0%, transparent 70%); border-radius: 50%; transform: translate(30%, -30%);"></div>
    <div class="position-absolute bottom-0 start-0" style="width: 300px; height: 300px; background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%); border-radius: 50%; transform: translate(-30%, 30%);"></div>

    <div class="container position-relative z-2">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="letter-spacing: 1px; font-size: 0.8rem;">
                    <i class="bi bi-mortarboard-fill me-1"></i> PROGRAM STUDI
                </span>
                <h1 class="display-4 fw-900 text-white mb-3" style="letter-spacing: -1px;">
                    {{ $program->name }}
                </h1>
                
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <div class="program-badge">
                        <div class="pb-icon"><i class="bi bi-award-fill"></i></div>
                        <div class="pb-text">
                            <span>Akreditasi</span>
                            <strong>{{ $program->accreditation }}</strong>
                        </div>
                    </div>
                    <div class="program-badge">
                        <div class="pb-icon"><i class="bi bi-layers-fill"></i></div>
                        <div class="pb-text">
                            <span>Jenjang</span>
                            <strong>{{ $program->level }}</strong>
                        </div>
                    </div>

                </div>

                <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top border-light border-opacity-25 align-items-center">
                    <span class="text-white-50" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-right: 8px;">Detail Legalitas:</span>
                    @if($program->accreditation_sk_number)
                    <div class="program-badge-sm">
                        <i class="bi bi-file-earmark-text-fill text-white-50"></i>
                        <span>SK: {{ $program->accreditation_sk_number }} ({{ $program->accreditation_year }})</span>
                    </div>
                    @endif
                    @if($program->accreditation_valid_until)
                    <div class="program-badge-sm">
                        <i class="bi bi-calendar-check-fill text-white-50"></i>
                        <span>Berlaku s.d. {{ $program->accreditation_valid_until->isoFormat('D MMM YYYY') }}</span>
                    </div>
                    @endif
                    @if($program->accreditation_certificate_url)
                    @php
                        // Extract file ID from Google Drive URL to build preview URL
                        preg_match('/id=([^&]+)/', $program->accreditation_certificate_url, $m);
                        $fileId = $m[1] ?? null;
                        $previewUrl = $fileId ? 'https://drive.google.com/file/d/' . $fileId . '/preview' : null;
                    @endphp
                    <button type="button" class="program-badge-sm btn-download-sm border-0" onclick="openCertPreview('{{ $previewUrl }}', '{{ $program->accreditation_certificate_url }}', '{{ $program->name }}')">
                        <i class="bi bi-file-earmark-pdf-fill text-white"></i>
                        <span class="text-white fw-bold">Lihat Sertifikat</span>
                    </button>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-4 d-none d-lg-block text-end" data-aos="fade-left">
                <div class="floating-icon-large">
                    @if(str_contains(strtolower($program->name), 'komputer') || str_contains(strtolower($program->name), 'informatika'))
                        <i class="bi bi-laptop"></i>
                    @elseif(str_contains(strtolower($program->name), 'sistem'))
                        <i class="bi bi-diagram-3"></i>
                    @else
                        <i class="bi bi-cpu"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="py-5 bg-light" style="margin-top: -30px;">
    <div class="container">
        <div class="row g-5">
            <!-- Left Column: Details -->
            <div class="col-lg-8">
                <!-- Deskripsi Card -->
                <div class="premium-card mb-4" data-aos="fade-up">
                    <h4 class="card-title-fancy">
                        <div class="icon-circle"><i class="bi bi-info-circle-fill"></i></div>
                        Deskripsi Program Studi
                    </h4>
                    <p class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                        {{ $program->description }}
                    </p>
                </div>

                <!-- Prospek Karier -->
                <div class="premium-card mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="card-title-fancy">
                        <div class="icon-circle bg-success text-white"><i class="bi bi-rocket-takeoff-fill"></i></div>
                        Prospek Karier Lulusan
                    </h4>
                    @php
                        $slug = $program->slug ?? '';
                        $name = strtolower($program->name ?? '');

                        if (str_contains($slug, 'teknik-informatika') || str_contains($name, 'teknik informatika')) {
                            $careers = [
                                ['icon' => 'bi-code-slash',         'color' => 'text-primary',   'title' => 'Software Engineer',         'desc' => 'Mengembangkan aplikasi, sistem, dan platform berbasis teknologi modern.'],
                                ['icon' => 'bi-phone',              'color' => 'text-success',   'title' => 'Mobile App Developer',      'desc' => 'Merancang dan membangun aplikasi Android & iOS yang fungsional.'],
                                ['icon' => 'bi-globe2',             'color' => 'text-info',      'title' => 'Web Developer / Full-Stack','desc' => 'Menguasai frontend & backend untuk pengembangan web profesional.'],
                                ['icon' => 'bi-cpu-fill',           'color' => 'text-danger',    'title' => 'AI / Machine Learning Engineer','desc' => 'Mengembangkan model kecerdasan buatan dan algoritma machine learning.'],
                                ['icon' => 'bi-shield-lock-fill',   'color' => 'text-warning',   'title' => 'Cybersecurity Analyst',     'desc' => 'Melindungi sistem dan data perusahaan dari ancaman siber.'],
                                ['icon' => 'bi-database-fill-gear', 'color' => 'text-secondary', 'title' => 'Database Administrator',    'desc' => 'Mengelola dan mengoptimalkan basis data skala enterprise.'],
                                ['icon' => 'bi-cloud-fill',         'color' => 'text-primary',   'title' => 'Cloud Engineer',            'desc' => 'Merancang infrastruktur cloud modern (AWS, GCP, Azure).'],
                                ['icon' => 'bi-bug-fill',           'color' => 'text-danger',    'title' => 'QA / Software Tester',      'desc' => 'Memastikan kualitas perangkat lunak sebelum rilis ke publik.'],
                            ];
                        } elseif (str_contains($slug, 'sistem-informasi') || str_contains($name, 'sistem informasi')) {
                            $careers = [
                                ['icon' => 'bi-kanban-fill',            'color' => 'text-primary',   'title' => 'Business Analyst',              'desc' => 'Menjembatani kebutuhan bisnis dengan solusi sistem informasi.'],
                                ['icon' => 'bi-bar-chart-fill',         'color' => 'text-success',   'title' => 'Data Analyst',                  'desc' => 'Mengolah dan menganalisis data untuk mendukung keputusan bisnis.'],
                                ['icon' => 'bi-diagram-3-fill',         'color' => 'text-info',      'title' => 'IT Project Manager',            'desc' => 'Memimpin proyek teknologi informasi dari perencanaan hingga delivery.'],
                                ['icon' => 'bi-gear-fill',              'color' => 'text-warning',   'title' => 'ERP / SAP Consultant',          'desc' => 'Mengimplementasikan dan mengkustomisasi sistem ERP perusahaan.'],
                                ['icon' => 'bi-graph-up-arrow',         'color' => 'text-danger',    'title' => 'Digital Transformation Analyst','desc' => 'Mendorong transformasi digital proses bisnis organisasi.'],
                                ['icon' => 'bi-person-lines-fill',      'color' => 'text-secondary', 'title' => 'IT Consultant',                 'desc' => 'Memberikan solusi dan strategi teknologi informasi kepada klien.'],
                                ['icon' => 'bi-layout-text-window-reverse','color'=>'text-primary',  'title' => 'Systems Analyst',               'desc' => 'Menganalisis dan merancang kebutuhan sistem informasi organisasi.'],
                                ['icon' => 'bi-shield-check',           'color' => 'text-success',   'title' => 'IT Governance & Auditor',       'desc' => 'Melakukan audit dan tata kelola teknologi informasi perusahaan.'],
                            ];
                        } elseif (str_contains($slug, 'manajemen-informatika') || str_contains($name, 'manajemen informatika')) {
                            $careers = [
                                ['icon' => 'bi-briefcase-fill',     'color' => 'text-primary',   'title' => 'IT Support & Helpdesk',     'desc' => 'Memberikan dukungan teknis kepada pengguna sistem komputer.'],
                                ['icon' => 'bi-server',             'color' => 'text-success',   'title' => 'Network Administrator',     'desc' => 'Mengelola dan memelihara infrastruktur jaringan perusahaan.'],
                                ['icon' => 'bi-brush-fill',         'color' => 'text-info',      'title' => 'Web Designer / UI Designer','desc' => 'Merancang tampilan visual website dan antarmuka pengguna yang menarik.'],
                                ['icon' => 'bi-megaphone-fill',     'color' => 'text-warning',   'title' => 'Digital Marketing Specialist','desc' => 'Mengelola strategi pemasaran digital berbasis platform online.'],
                                ['icon' => 'bi-cart4',              'color' => 'text-danger',    'title' => 'E-Commerce Specialist',     'desc' => 'Mengelola operasional bisnis perdagangan elektronik.'],
                                ['icon' => 'bi-journal-code',       'color' => 'text-secondary', 'title' => 'Junior Programmer',         'desc' => 'Membangun dan memelihara aplikasi perangkat lunak skala menengah.'],
                                ['icon' => 'bi-camera-video-fill',  'color' => 'text-primary',   'title' => 'Content Creator / Media',   'desc' => 'Memproduksi konten digital kreatif untuk berbagai platform media.'],
                                ['icon' => 'bi-shop',               'color' => 'text-success',   'title' => 'Technopreneur / Wirausaha', 'desc' => 'Membangun usaha berbasis teknologi informasi secara mandiri.'],
                            ];
                        } elseif (str_contains($slug, 'komputerisasi-akuntansi') || str_contains($name, 'komputerisasi akuntansi')) {
                            $careers = [
                                ['icon' => 'bi-calculator-fill',    'color' => 'text-primary',   'title' => 'Akuntan Publik / Staf Akuntansi','desc' => 'Mengelola laporan keuangan, pembukuan, dan auditing perusahaan.'],
                                ['icon' => 'bi-receipt-cutoff',     'color' => 'text-success',   'title' => 'Finance & Accounting Staff', 'desc' => 'Menjalankan fungsi keuangan dan akuntansi di perusahaan.'],
                                ['icon' => 'bi-laptop',             'color' => 'text-info',      'title' => 'Operator Sistem Akuntansi',  'desc' => 'Mengoperasikan software akuntansi seperti MYOB, Accurate, SAP.'],
                                ['icon' => 'bi-bank',               'color' => 'text-warning',   'title' => 'Staf Perbankan & Keuangan',  'desc' => 'Berkarir di bidang perbankan, koperasi, dan lembaga keuangan.'],
                                ['icon' => 'bi-search',             'color' => 'text-danger',    'title' => 'Internal Auditor',           'desc' => 'Mengaudit dan memastikan kepatuhan keuangan internal organisasi.'],
                                ['icon' => 'bi-bar-chart-steps',    'color' => 'text-secondary', 'title' => 'Tax Consultant (Konsultan Pajak)','desc' => 'Memberikan layanan konsultasi perpajakan kepada klien bisnis.'],
                                ['icon' => 'bi-journal-check',      'color' => 'text-primary',   'title' => 'Analis Keuangan / Financial Analyst','desc' => 'Menganalisis data keuangan untuk pengambilan keputusan investasi.'],
                                ['icon' => 'bi-file-earmark-spreadsheet-fill','color'=>'text-success','title'=>'Staf Anggaran & Perencanaan Keuangan','desc'=>'Menyusun dan memantau anggaran serta perencanaan keuangan perusahaan.'],
                            ];
                        } else {
                            $careers = [
                                ['icon' => 'bi-code-slash',         'color' => 'text-primary',   'title' => 'Software Developer',    'desc' => 'Mengembangkan perangkat lunak dan aplikasi untuk berbagai platform.'],
                                ['icon' => 'bi-diagram-3',          'color' => 'text-success',   'title' => 'Systems Analyst',       'desc' => 'Menganalisis dan merancang solusi sistem informasi.'],
                                ['icon' => 'bi-server',             'color' => 'text-info',      'title' => 'Network Administrator', 'desc' => 'Mengelola infrastruktur jaringan dan keamanan data.'],
                                ['icon' => 'bi-headset',            'color' => 'text-warning',   'title' => 'IT Consultant',         'desc' => 'Memberikan solusi teknologi informasi kepada klien.'],
                                ['icon' => 'bi-globe2',             'color' => 'text-danger',    'title' => 'Web Developer',         'desc' => 'Membangun dan mengembangkan website profesional.'],
                                ['icon' => 'bi-wifi',               'color' => 'text-secondary', 'title' => 'Network Engineer',      'desc' => 'Merancang dan mengoptimalkan infrastruktur jaringan komputer.'],
                            ];
                        }
                    @endphp
                    <div class="row g-3 mt-1">
                        @foreach($careers as $career)
                            <div class="col-md-6">
                                <div class="career-item career-item-rich">
                                    <div class="career-icon-wrap">
                                        <i class="bi {{ $career['icon'] }} {{ $career['color'] }} fs-5"></i>
                                    </div>
                                    <div class="career-text">
                                        <span class="fw-bold text-dark d-block" style="font-size:0.92rem;">{{ $career['title'] }}</span>
                                        <span class="text-muted" style="font-size:0.78rem; line-height:1.4;">{{ $career['desc'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Keunggulan / Kurikulum -->
                <div class="premium-card" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="card-title-fancy">
                        <div class="icon-circle bg-warning text-dark"><i class="bi bi-lightbulb-fill"></i></div>
                        Keunggulan & Kurikulum
                    </h4>
                    <p class="text-muted mb-4">Kurikulum dirancang khusus agar relevan dengan kebutuhan industri teknologi informasi global (Link & Match).</p>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="feature-row">
                            <div class="fr-icon"><i class="bi bi-pc-display"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Praktikum Laboratorium</h6>
                                <p class="text-muted small mb-0">Fasilitas lab komputer modern dengan software terlisensi standar industri.</p>
                            </div>
                        </div>
                        <div class="feature-row">
                            <div class="fr-icon"><i class="bi bi-building"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Kemitraan Industri</h6>
                                <p class="text-muted small mb-0">Program magang (internship) dan penyaluran kerja di berbagai perusahaan IT terkemuka.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Action & Info -->
            <div class="col-lg-4">
                <div class="sticky-sidebar" data-aos="fade-left" data-aos-delay="300">
                    <!-- Action Card -->
                    <div class="premium-card glass-card text-center text-white mb-4 overflow-hidden position-relative">
                        <div class="position-absolute inset-0 bg-primary opacity-75 z-0"></div>
                        <div class="position-relative z-1 p-3">
                            <h3 class="fw-bold mb-2">Siap Bergabung?</h3>
                            <p class="small text-white-50 mb-4">Jadilah bagian dari generasi digital inovatif STMIK ROSMA.</p>
                            
                            <a href="{{ route('applications.create') }}" class="btn btn-light w-100 py-3 rounded-pill fw-bold text-primary shadow-sm btn-bounce">
                                <i class="bi bi-pencil-square me-2"></i> Daftar Sekarang
                            </a>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="premium-card p-4">
                        <h5 class="fw-bold mb-4 border-bottom pb-2">Informasi Singkat</h5>
                        
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-light">
                            <span class="text-muted"><i class="bi bi-calendar3 me-2"></i> Masa Studi</span>
                            <strong class="text-dark">{{ $program->level == 'S1' ? '8 Semester (4 Tahun)' : '6 Semester (3 Tahun)' }}</strong>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="bi bi-wallet2 me-2"></i> Estimasi Biaya</span>
                            <a href="{{ route('fees.index') }}" class="fw-bold text-primary text-decoration-none">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Hero Badges */
    .program-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 10px 20px;
        border-radius: 16px;
    }
    .pb-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    .pb-text { display: flex; flex-direction: column; line-height: 1.2; }
    .pb-text span { font-size: 0.7rem; color: rgba(255, 255, 255, 0.7); text-transform: uppercase; letter-spacing: 1px; }
    .pb-text strong { color: white; font-size: 1rem; font-weight: 700; }

    /* Small Detail Badges (Legalitas) */
    .program-badge-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.8);
    }
    .btn-download-sm {
        background: rgba(37, 99, 235, 0.4);
        border-color: rgba(37, 99, 235, 0.6);
        text-decoration: none;
        transition: background 0.2s ease;
    }
    .btn-download-sm:hover {
        background: rgba(37, 99, 235, 0.8);
    }

    /* Floating Icon */
    .floating-icon-large {
        font-size: 12rem;
        color: rgba(255, 255, 255, 0.15);
        animation: floatIcon 6s ease-in-out infinite;
        text-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    @keyframes floatIcon {
        0%, 100% { transform: translateY(0) rotate(-5deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    /* Premium Cards */
    .premium-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    }
    
    .card-title-fancy {
        display: flex;
        align-items: center;
        gap: 15px;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 25px;
        font-size: 1.4rem;
    }
    .icon-circle {
        width: 45px;
        height: 45px;
        background: rgba(37, 99, 235, 0.1);
        color: var(--accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    /* List styling */
    .career-item {
        background: #f8fafc;
        padding: 12px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .career-item:hover { background: white; border-color: var(--success); transform: translateX(5px); }

    /* Rich career item with icon + desc */
    .career-item-rich { align-items: flex-start; padding: 14px 16px; }
    .career-item-rich:hover { border-color: var(--accent); transform: translateX(4px); box-shadow: 0 4px 15px rgba(37,99,235,0.08); }
    .career-icon-wrap { width: 38px; height: 38px; border-radius: 10px; background: #f0f4ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .career-text { flex: 1; }

    .feature-row {
        display: flex;
        gap: 15px;
        padding: 15px;
        border-radius: 16px;
        background: #f8fafc;
        transition: background 0.3s;
    }
    .feature-row:hover { background: #eff6ff; }
    .fr-icon {
        width: 40px;
        height: 40px;
        background: var(--accent);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Glass Action Card */
    .glass-card {
        background: linear-gradient(135deg, var(--primary), var(--accent));
    }
    
    .sticky-sidebar { position: sticky; top: 100px; }

    .btn-bounce { transition: transform 0.3s; }
    .btn-bounce:hover { transform: scale(1.05); }
</style>
@endpush

{{-- Modal Preview Sertifikat --}}
<div class="modal fade" id="certPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 780px;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 px-4 pt-4 pb-2" style="background:#0F172A;">
                <div>
                    <h6 class="fw-bold text-white mb-0" id="certPreviewTitle">Sertifikat Akreditasi</h6>
                    <p class="text-white-50 small mb-0">Preview dokumen sebelum mengunduh</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div style="background:#1E293B; padding: 0;">
                <iframe id="certPreviewFrame"
                    src=""
                    width="100%"
                    height="520px"
                    frameborder="0"
                    allow="autoplay"
                    style="display:block;"
                    loading="lazy">
                </iframe>
            </div>
            <div class="modal-footer border-0 px-4 py-3" style="background:#F8FAFC;">
                <span class="text-muted small me-auto"><i class="bi bi-shield-check text-success me-1"></i>Dokumen resmi LAM-INFOKOM</span>
                <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
                <a id="certDownloadBtn" href="#" target="_blank"
                   class="btn btn-primary rounded-pill px-4 fw-semibold" style="background:#4F46E5; border:none;">
                    <i class="bi bi-cloud-arrow-down-fill me-2"></i>Unduh PDF
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openCertPreview(previewUrl, downloadUrl, programName) {
    document.getElementById('certPreviewTitle').textContent = 'Sertifikat Akreditasi — ' + programName;
    document.getElementById('certPreviewFrame').src = previewUrl;
    document.getElementById('certDownloadBtn').href = downloadUrl;
    new bootstrap.Modal(document.getElementById('certPreviewModal')).show();
}
// Clear iframe src when modal is closed (stop loading)
document.getElementById('certPreviewModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('certPreviewFrame').src = '';
});
</script>
@endpush

@endsection
