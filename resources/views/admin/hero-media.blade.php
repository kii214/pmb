@extends('layouts.admin')

@section('title', 'Foto Mahasiswa (Almet) Beranda')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color:#0F172A;">
            <i class="bi bi-person-bounding-box text-primary me-2"></i>Foto Mahasiswa (Almet) Beranda
        </h4>
        <p class="text-muted mb-0" style="font-size:0.875rem;">
            Kelola foto profil mahasiswa berjas almamater dan informasi kampus yang tampil di halaman utama (Home).
        </p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success d-flex align-items-center mb-4 rounded-3" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

<div class="row g-4">
    {{-- SISI KIRI: FORM UPLOAD & PENGATURAN --}}
    <div class="col-lg-6">
        <div class="admin-card p-4 h-100">
            <h6 class="fw-bold text-dark mb-3">
                <i class="bi bi-cloud-arrow-up-fill text-primary me-2"></i>Upload Foto Baru
            </h6>
            
            <form action="{{ route('admin.hero_media.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="font-size:0.85rem;">Pilih File Gambar</label>
                    <input type="file" name="hero_image" id="heroImageInput" class="form-control" accept="image/*" onchange="previewHeroImage(event)">
                    <small class="text-muted d-block mt-1">
                        Format yang didukung: JPG, PNG, WEBP. Maksimal ukuran file 5 MB. Disarankan foto portrait atau aspek rasio 4:5.
                    </small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="font-size:0.85rem;">Keterangan Lokasi / Kampus (Caption)</label>
                    <input type="text" name="hero_caption" class="form-control" 
                           placeholder="Contoh: Jl. Kertabumi No. 62, Karawang Barat"
                           value="{{ old('hero_caption', $setting->hero_caption ?? 'Jl. Kertabumi No. 62, Karawang Barat') }}">
                    <small class="text-muted d-block mt-1">
                        Teks ini akan tampil di bagian badge bawah foto mahasiswa di halaman utama.
                    </small>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-primary px-4 fw-semibold rounded-3" style="background:#4F46E5; border:none;">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>

            @if($setting->hero_image)
            <hr class="my-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold text-dark mb-1" style="font-size:0.85rem;">Reset ke Foto Default</h6>
                    <small class="text-muted">Kembalikan ke foto mahasiswa almamater asli (student-almamater.jpg).</small>
                </div>
                <form action="{{ route('admin.hero_media.reset') }}" method="POST" onsubmit="return confirm('Kembalikan ke foto default?');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-3">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Foto
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    {{-- SISI KANAN: LIVE PREVIEW TAMPILAN BERANDA --}}
    <div class="col-lg-6">
        <div class="admin-card p-4">
            <h6 class="fw-bold text-dark mb-3">
                <i class="bi bi-eye-fill text-info me-2"></i>Live Preview Tampilan Beranda
            </h6>

            @php
                $activePhoto = $setting->hero_image ? asset('storage/' . $setting->hero_image) : asset('images/student-almamater.jpg');
                $caption = $setting->hero_caption ?: 'Jl. Kertabumi No. 62, Karawang Barat';
            @endphp

            <div class="p-3 bg-light rounded-4 border">
                <div class="position-relative rounded-4 overflow-hidden shadow-sm" style="background:#0c1024; border: 1px solid #e2e8f0;">
                    <img id="imagePreviewTarget" src="{{ $activePhoto }}" alt="Preview Foto Mahasiswa" 
                         style="width:100%; height:380px; object-fit:cover; object-position:top center; display:block;">
                    
                    {{-- Badge Overlay --}}
                    <div style="position:absolute; bottom:14px; left:14px; right:14px; background:rgba(15,23,42,0.85); backdrop-filter:blur(6px); color:#fff; padding:10px 14px; border-radius:12px; display:flex; align-items:center; justify-content:space-between; gap:10px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                            <div>
                                <strong class="d-block" style="font-size:0.82rem; line-height:1.2;">Kampus Utama STMIK ROSMA</strong>
                                <small class="text-white-50" id="captionPreviewTarget" style="font-size:0.72rem;">{{ $caption }}</small>
                            </div>
                        </div>
                        <span class="badge bg-primary px-2 py-1 rounded-pill small fw-bold" style="font-size:0.68rem;">PMB Online</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 text-muted small">
                <i class="bi bi-info-circle me-1 text-primary"></i>
                Status foto saat ini: 
                @if($setting->hero_image)
                    <strong class="text-success">Foto Kustom Admin</strong>
                @else
                    <strong class="text-primary">Foto Default Mahasiswa Almamater</strong>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewHeroImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreviewTarget').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
