@extends('layouts.public')

@section('title', 'Form Pendaftaran Mahasiswa Baru')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary) 0%, #0a1535 100%); padding: 110px 0 90px; min-height: 300px; position: relative; overflow: hidden;">
    <div class="position-absolute top-0 end-0" style="width: 300px; height: 300px; background: radial-gradient(circle, rgba(37,99,235,0.2) 0%, transparent 70%); border-radius: 50%; transform: translate(30%, -30%);"></div>
    <div class="position-absolute bottom-0 start-0" style="width: 250px; height: 250px; background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%); border-radius: 50%; transform: translate(-30%, 30%);"></div>
    
    <div class="container text-center text-white position-relative z-2">
        <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="letter-spacing: 1px; font-size: 0.8rem;">
            <i class="bi bi-ui-checks-grid me-1"></i> REGISTRASI ONLINE
        </span>
        <h1 class="display-5 fw-900 mb-3" style="letter-spacing: -1px;">Formulir Pendaftaran</h1>
        <p class="text-white-50 lead mx-auto mb-4" style="max-width: 650px;">Lengkapi data diri Anda di bawah ini untuk memulai perjalanan karir digital gemilang bersama STMIK ROSMA.</p>
    </div>
</div>

<div class="container" style="margin-top: -45px; margin-bottom: 100px; position: relative; z-index: 5;">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Sidebar Wizard -->
                        <div class="col-md-4 d-none d-md-flex flex-column" style="background: linear-gradient(160deg, #0d1b2a 0%, #12325a 60%, #1a4480 100%); position: relative; overflow: hidden; min-height: 600px;">

                            {{-- Animated Vue Sidebar --}}
                            <div id="regSidebar"
                                style="flex:1;display:flex;flex-direction:column;position:relative;z-index:2;">
                            </div>
                        </div>


                        <!-- Form Area -->
                        <div class="col-md-8 p-4 p-lg-5">
                            @if ($errors->any())
                                <div class="alert alert-danger rounded-3 border-0 bg-danger-subtle text-danger-emphasis mb-4">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('applications.store') }}" method="POST" id="registrationForm">
                                @csrf
                                
                                <!-- ================= STEP 1: DATA DIRI & KELUARGA ================= -->
                                <div class="form-step active" id="step-1">
                                    <h4 class="fw-bold mb-4">A. Data Diri Calon Mahasiswa</h4>
                                    <div class="row g-3 mb-5">
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted small">Nama Lengkap (Sesuai Ijazah)</label>
                                            <input type="text" name="full_name" class="form-control form-control-lg bg-light input-letter-only" value="{{ old('full_name') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Nomor Induk Kependudukan (NIK)</label>
                                            <input type="text" name="nik" class="form-control bg-light input-number-only" inputmode="numeric" value="{{ old('nik') }}" maxlength="16" minlength="16" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Nomor Telepon/WhatsApp</label>
                                            <input type="tel" name="phone" class="form-control bg-light input-number-only" inputmode="numeric" value="{{ old('phone') }}" maxlength="15" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Tempat Lahir</label>
                                            <input type="text" name="birth_place" class="form-control bg-light input-letter-only" value="{{ old('birth_place') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Tanggal Lahir</label>
                                            <input type="date" name="birth_date" class="form-control bg-light" value="{{ old('birth_date') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Jenis Kelamin</label>
                                            <div class="d-flex gap-2">
                                                <div class="form-check custom-radio flex-fill">
                                                    <input class="form-check-input" type="radio" name="gender" id="genderL" value="L" {{ old('gender') == 'L' ? 'checked' : '' }} required>
                                                    <label class="form-check-label w-100 p-2 text-center rounded-3 bg-light" for="genderL">Laki-laki</label>
                                                </div>
                                                <div class="form-check custom-radio flex-fill">
                                                    <input class="form-check-input" type="radio" name="gender" id="genderP" value="P" {{ old('gender') == 'P' ? 'checked' : '' }} required>
                                                    <label class="form-check-label w-100 p-2 text-center rounded-3 bg-light" for="genderP">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Agama</label>
                                            <select name="religion" class="form-select bg-light" required>
                                                <option value="">Pilih Agama</option>
                                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                <option value="Kristen Protestan" {{ old('religion') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                                <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted small">Alamat Lengkap</label>
                                            <textarea name="address" class="form-control bg-light" rows="2" required>{{ old('address') }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Provinsi</label>
                                            <input type="text" name="province" class="form-control bg-light input-letter-only" value="{{ old('province') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Kota/Kabupaten</label>
                                            <input type="text" name="city" class="form-control bg-light input-letter-only" value="{{ old('city') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Kode Pos</label>
                                            <input type="text" name="postal_code" class="form-control bg-light input-number-only" inputmode="numeric" value="{{ old('postal_code') }}" maxlength="5" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted small">Alamat Email</label>
                                            <input type="email" name="email" class="form-control bg-light" value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    <h4 class="fw-bold mb-4">E. Data Orang Tua / Wali</h4>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Nama Ayah</label>
                                            <input type="text" name="father_name" class="form-control bg-light input-letter-only" value="{{ old('father_name') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Pekerjaan Ayah</label>
                                            <input type="text" name="father_job" class="form-control bg-light input-letter-only" value="{{ old('father_job') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Penghasilan Ayah</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                                <input type="text" name="father_income" class="form-control bg-light border-start-0 input-number-only" inputmode="numeric" value="{{ old('father_income') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Nama Ibu</label>
                                            <input type="text" name="mother_name" class="form-control bg-light input-letter-only" value="{{ old('mother_name') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Pekerjaan Ibu</label>
                                            <input type="text" name="mother_job" class="form-control bg-light input-letter-only" value="{{ old('mother_job') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium text-muted small">Penghasilan Ibu</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                                <input type="text" name="mother_income" class="form-control bg-light border-start-0 input-number-only" inputmode="numeric" value="{{ old('mother_income') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted small">Nomor Telepon Orang Tua/Wali</label>
                                            <input type="tel" name="parent_phone" class="form-control bg-light input-number-only" inputmode="numeric" value="{{ old('parent_phone') }}" maxlength="15" required>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-top text-end">
                                        <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm" onclick="nextStep(1)">Selanjutnya <i class="bi bi-arrow-right ms-2"></i></button>
                                    </div>
                                </div>

                                <!-- ================= STEP 2: PENDIDIKAN ASAL ================= -->
                                <div class="form-step d-none" id="step-2">
                                    <h4 class="fw-bold mb-4">B. Data Pendidikan Asal</h4>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted small">Asal Sekolah (SMA/SMK/MA)</label>
                                            <input type="text" name="school_name" class="form-control form-control-lg bg-light" value="{{ old('school_name') }}" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted small">Nomor Induk Siswa Nasional (NISN)</label>
                                            <input type="text" name="nisn" class="form-control bg-light input-number-only" inputmode="numeric" value="{{ old('nisn') }}" maxlength="10" minlength="10" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Jurusan</label>
                                            <input type="text" name="major" class="form-control bg-light input-letter-only" value="{{ old('major') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Tahun Lulus</label>
                                            <input type="text" name="graduation_year" class="form-control bg-light input-number-only" inputmode="numeric" value="{{ old('graduation_year') }}" maxlength="4" required>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btn-outline-secondary px-4 rounded-pill fw-semibold" onclick="prevStep(2)"><i class="bi bi-arrow-left me-2"></i> Kembali ke Data Diri (A)</button>
                                        <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm" onclick="nextStep(2)">Selanjutnya <i class="bi bi-arrow-right ms-2"></i></button>
                                    </div>
                                </div>

                                <!-- ================= STEP 3: PROGRAM & REFERENSI ================= -->
                                <div class="form-step d-none" id="step-3">
                                    <h4 class="fw-bold mb-4">C. Jalur Pendaftaran & Program Studi</h4>
                                    <div class="row g-3 mb-5">
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Jalur Pendaftaran <span class="text-danger">*</span></label>
                                            <select name="registration_path_id" class="form-select bg-light" required>
                                                <option value="">Pilih Jalur</option>
                                                @foreach($paths as $path)
                                                    <option value="{{ $path->id }}" {{ old('registration_path_id') == $path->id ? 'selected' : '' }}>{{ $path->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Nomor KIP (Jika ada)</label>
                                            <input type="text" name="kip_number" class="form-control bg-light" value="{{ old('kip_number') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Pilihan Program Studi 1 <span class="text-danger">*</span></label>
                                            <select name="program_study_id" id="prodiChoice1" class="form-select bg-light" required>
                                                <option value="">Pilih Program Studi 1 (Utama)</option>
                                                @foreach($programs as $program)
                                                    <option value="{{ $program->id }}" {{ old('program_study_id') == $program->id ? 'selected' : '' }}>{{ $program->name }} ({{ $program->level }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Pilihan Program Studi 2 <span class="text-muted">(Pilihan Cadangan)</span></label>
                                            <select name="program_study_2_id" id="prodiChoice2" class="form-select bg-light">
                                                <option value="">Pilih Program Studi 2 (Opsional)</option>
                                                @foreach($programs as $program)
                                                    <option value="{{ $program->id }}" {{ old('program_study_2_id') == $program->id ? 'selected' : '' }}>{{ $program->name }} ({{ $program->level }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted small">Kelas yang Diminati <span class="text-danger">*</span></label>
                                            <select name="class_type" class="form-select bg-light" required>
                                                <option value="">Pilih Kelas</option>
                                                <option value="Reguler Pagi" {{ old('class_type') == 'Reguler Pagi' ? 'selected' : '' }}>Reguler Pagi</option>
                                                <option value="Reguler Malam" {{ old('class_type') == 'Reguler Malam' ? 'selected' : '' }}>Reguler Malam</option>
                                            </select>
                                        </div>
                                    </div>

                                    <h4 class="fw-bold mb-4">D. Sumber Informasi & Referensi</h4>
                                    <div class="row g-3 mb-4">
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted small">Darimana Anda mengetahui informasi pendaftaran?</label>
                                            <select name="info_source" class="form-select bg-light" required>
                                                <option value="">Pilih Sumber</option>
                                                <option value="Guru BK / Guru" {{ old('info_source') == 'Guru BK / Guru' ? 'selected' : '' }}>Guru BK / Guru</option>
                                                <option value="Presentasi/Kunjungan Kampus" {{ old('info_source') == 'Presentasi/Kunjungan Kampus' ? 'selected' : '' }}>Presentasi/Kunjungan Kampus</option>
                                                <option value="Media Sosial" {{ old('info_source') == 'Media Sosial' ? 'selected' : '' }}>Media Sosial</option>
                                                <option value="Keluarga/Teman" {{ old('info_source') == 'Keluarga/Teman' ? 'selected' : '' }}>Keluarga/Teman</option>
                                                <option value="Alumni/Mahasiswa" {{ old('info_source') == 'Alumni/Mahasiswa' ? 'selected' : '' }}>Alumni/Mahasiswa</option>
                                                <option value="Website Resmi" {{ old('info_source') == 'Website Resmi' ? 'selected' : '' }}>Website Resmi</option>
                                                <option value="Spanduk / Brosur" {{ old('info_source') == 'Spanduk / Brosur' ? 'selected' : '' }}>Spanduk / Brosur</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">Nama Referensi</label>
                                            <input type="text" name="reference_name" class="form-control bg-light input-letter-only" value="{{ old('reference_name') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium text-muted small">NIM/NIDN Referensi</label>
                                            <input type="text" name="reference_id" class="form-control bg-light input-number-only" inputmode="numeric" value="{{ old('reference_id') }}">
                                        </div>
                                    </div>

                                    <div class="card border border-primary bg-primary-subtle text-dark rounded-4 mb-4">
                                        <div class="card-body">
                                            <div class="form-check custom-checkbox">
                                                <input class="form-check-input mt-1 border-primary" type="checkbox" name="statement_agree" id="statement_agree" required style="width:1.2rem; height:1.2rem; cursor:pointer;">
                                                <label class="form-check-label ms-2 fw-semibold" for="statement_agree" style="font-size:0.9rem; line-height:1.5; cursor:pointer;">
                                                    Dengan ini saya menyatakan bahwa seluruh data yang saya berikan adalah BENAR. Apabila di kemudian hari terbukti ada pemalsuan data, saya bersedia menerima sanksi sesuai aturan yang berlaku.
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 bg-light rounded-4 border">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="fw-bold text-muted small text-uppercase">Captcha</div>
                                            <div class="bg-white px-3 py-2 rounded fw-bold fs-5 shadow-sm text-primary">{{ $captcha_num1 }} + {{ $captcha_num2 }} = ?</div>
                                            <div>
                                                <input type="number" name="captcha_answer" class="form-control fw-bold text-center border-primary" style="width: 80px;" placeholder="?" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">
                                            <i class="bi bi-send-fill me-2"></i> Kirim Formulir
                                        </button>
                                    </div>

                                    <div class="mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-light px-4 rounded-pill" onclick="prevStep(3)"><i class="bi bi-arrow-left me-2"></i> Kembali</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Wizard Sidebar Styles */
    .wizard-steps { position: sticky; top: 100px; }
    .wizard-step { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; opacity: 0.4; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: default; }
    .wizard-step.active { opacity: 1; transform: translateX(10px); }
    .wizard-step .step-icon { width: 48px; height: 48px; border-radius: 14px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: #64748b; transition: all 0.3s; }
    .wizard-step.active .step-icon { background: linear-gradient(135deg, var(--accent), var(--primary)); color: white; box-shadow: 0 8px 20px rgba(37,99,235,0.3); transform: scale(1.1); }
    .wizard-step .step-text h6 { margin: 0; font-weight: 800; color: #1e293b; letter-spacing: -0.02em; }
    .wizard-step.active .step-text h6 { color: var(--primary); }
    .wizard-step .step-text small { font-weight: 500; }

    /* Dark sidebar wizard variant */
    .wizard-steps-dark .wizard-step .step-icon { background: rgba(255,255,255,.1); color: rgba(255,255,255,.5); }
    .wizard-steps-dark .wizard-step.active .step-icon { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; box-shadow: 0 6px 18px rgba(245,158,11,.35); }
    .wizard-steps-dark .wizard-step .step-text h6 { color: rgba(255,255,255,.5); font-size: .85rem; }
    .wizard-steps-dark .wizard-step.active .step-text h6 { color: #fff; }
    .wizard-steps-dark .wizard-step .step-text small { color: rgba(255,255,255,.35); font-size: .75rem; }
    .wizard-steps-dark .wizard-step.active .step-text small { color: rgba(255,255,255,.6); }

    /* Custom Input Styling */
    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
        background: white !important;
    }
    .input-group-text { border-color: #e2e8f0; border-radius: 12px; }

    /* Custom Radio Buttons */
    .custom-radio .form-check-input { display: none; }
    .custom-radio .form-check-label { 
        cursor: pointer; 
        transition: all 0.2s; 
        border: 2px solid #e2e8f0 !important; 
    }
    .custom-radio .form-check-label:hover { background-color: white !important; border-color: #cbd5e1 !important; }
    .custom-radio .form-check-input:checked + .form-check-label {
        background-color: #eff6ff !important;
        border-color: var(--accent) !important;
        color: var(--primary) !important;
        font-weight: 700;
    }
</style>
@endpush

@push('scripts')
{{-- Vue 3 CDN --}}
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="{{ asset('js/reg-sidebar.js') }}?v={{ time() }}"></script>
<script>
// ── Step Navigation ────────────────────────────────────────────────────
function nextStep(step) {
    const currentStep = document.getElementById('step-' + step)
    const inputs = currentStep.querySelectorAll('input[required], select[required], textarea[required]')
    let isValid = true
    inputs.forEach(input => {
        if (!input.checkValidity()) { input.reportValidity(); isValid = false }
    })
    if (isValid) {
        document.getElementById('step-' + step).classList.add('d-none')
        const nextEl = document.getElementById('step-' + (step + 1))
        nextEl.classList.remove('d-none')
        try { document.getElementById('regSidebar').dispatchEvent(new CustomEvent('setstep', { detail: step + 1 })) } catch(e) {}
        
        const formCard = document.querySelector('.card.border-0.shadow-lg')
        if (formCard) {
            const yOffset = -40;
            const y = formCard.getBoundingClientRect().top + window.pageYOffset + yOffset;
            window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' })
        }
    }
}

function prevStep(step) {
    document.getElementById('step-' + step).classList.add('d-none')
    const prevEl = document.getElementById('step-' + (step - 1))
    prevEl.classList.remove('d-none')
    try { document.getElementById('regSidebar').dispatchEvent(new CustomEvent('setstep', { detail: step - 1 })) } catch(e) {}
    
    const formCard = document.querySelector('.card.border-0.shadow-lg')
    if (formCard) {
        const yOffset = -40;
        const y = formCard.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' })
    }
}

// ── Strict Input Restrictions (Numbers only vs Letters only) ─────────────
document.addEventListener('DOMContentLoaded', function () {
    // 1. Only Digits (Angka saja): NIK, Telepon, NISN, Kode Pos, Penghasilan, Tahun, Captcha, NIM
    const numberInputs = document.querySelectorAll('.input-number-only');
    numberInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text');
            this.value = text.replace(/[^0-9]/g, '');
        });
    });

    // 2. Only Letters, Spaces & Common Punctuation for Names (Huruf saja): Nama, Tempat Lahir, Provinsi, Kota, Pekerjaan, Jurusan
    const textInputs = document.querySelectorAll('.input-letter-only');
    textInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z\s.,'`-]/g, '');
        });
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text');
            this.value = text.replace(/[^a-zA-Z\s.,'`-]/g, '');
        });
    });

    // ── 3. Auto-Save & Auto-Restore Form Cache (localStorage) ───────────
    const form = document.getElementById('registrationForm');
    const STORAGE_KEY = 'pmb_rosma_form_draft_v1';

    // A. Restore cached data if input has no server old() value
    try {
        const savedData = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
        Object.keys(savedData).forEach(name => {
            if (name === 'captcha_answer' || name === 'statement_agree') return;
            const field = form.elements[name];
            if (field) {
                if (field instanceof RadioNodeList || field.type === 'radio') {
                    const radio = form.querySelector(`input[name="${name}"][value="${savedData[name]}"]`);
                    if (radio && !form.querySelector(`input[name="${name}"]:checked`)) {
                        radio.checked = true;
                    }
                } else if (field.type === 'checkbox') {
                    // skip
                } else if (!field.value && savedData[name]) {
                    field.value = savedData[name];
                }
            }
        });
    } catch(e) {}

    // B. Auto-save on every input change
    function saveFormCache() {
        const data = {};
        const elements = form.elements;
        for (let i = 0; i < elements.length; i++) {
            const el = elements[i];
            if (!el.name || el.type === 'password' || el.name === 'captcha_answer' || el.name === 'statement_agree' || el.name === '_token') continue;
            if (el.type === 'radio') {
                if (el.checked) data[el.name] = el.value;
            } else if (el.type !== 'checkbox') {
                if (el.value) data[el.name] = el.value;
            }
        }
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(data)); } catch(e) {}
    }

    form.addEventListener('input', saveFormCache);
    form.addEventListener('change', saveFormCache);

    // C. Clear cache on successful submit
    form.addEventListener('submit', function() {
        // Will clear on next page load or we leave draft until success
    });

    // D. If page refreshed with validation errors, automatically open the step with the error
    @if($errors->any())
        // Cari step yang berisi input error
        const steps = [1, 2, 3];
        let errorStep = 1;
        for (let s of steps) {
            const stepEl = document.getElementById('step-' + s);
            if (stepEl && stepEl.querySelector('.is-invalid, input:invalid, select:invalid')) {
                errorStep = s;
                break;
            }
        }
        if (errorStep > 1) {
            document.getElementById('step-1').classList.add('d-none');
            document.getElementById('step-' + errorStep).classList.remove('d-none');
            try { document.getElementById('regSidebar').dispatchEvent(new CustomEvent('setstep', { detail: errorStep })) } catch(e) {}
        }
    @endif
});
</script>

<style>
@keyframes regFloat {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    33%       { transform: translateY(-9px) rotate(3deg); }
    66%       { transform: translateY(-4px) rotate(-2deg); }
}
@keyframes regPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(251,191,36,.5); }
    50%       { box-shadow: 0 0 0 6px rgba(251,191,36,0); }
}
@endpush
