@extends('layouts.admin')

@section('title', 'Pengaturan Sistem & Kontak')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Pengaturan Sistem</h3>
    <p class="text-muted mb-0">Atur kontak publik dan rekening bank pembayaran pendaftaran.</p>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 border-0 fw-medium">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="bi bi-bank me-2 text-primary"></i>Pengaturan Pembayaran & Rekening</h6>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.settings.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Bank</label>
                        <input type="text" name="bank_name" class="form-control" value="{{ $setting->bank_name ?? 'BCA' }}" placeholder="Contoh: Bank BCA" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nomor Rekening</label>
                        <input type="text" name="bank_account" class="form-control font-monospace" value="{{ $setting->bank_account ?? '1234567890' }}" placeholder="Contoh: 1234567890" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Atas Nama Rekening</label>
                        <input type="text" name="account_name" class="form-control" value="{{ $setting->account_name ?? 'STMIK ROSMA' }}" placeholder="Contoh: Yayasan Pendidikan Rosma" required>
                    </div>

                    <h6 class="admin-card-title mb-3 mt-5 border-top pt-4"><i class="bi bi-telephone-fill me-2 text-success"></i>Kontak & Pesan Default</h6>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Admin / Institusi</label>
                        <input type="text" name="admin_name" class="form-control" value="{{ $setting->admin_name ?? 'Admin PMB STMIK ROSMA' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nomor WhatsApp (Gunakan 62)</label>
                        <input type="text" name="whatsapp_number" class="form-control" value="{{ $setting->whatsapp_number ?? '6281234567890' }}" placeholder="Contoh: 6281234567890" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Pesan Default (Template Chat)</label>
                        <textarea name="whatsapp_message" class="form-control" rows="3" required>{{ $setting->whatsapp_message ?? 'Halo Admin PMB STMIK ROSMA, saya ingin bertanya.' }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill">Simpan Pengaturan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card bg-primary-subtle border-0">
            <div class="admin-card-body p-4">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i>Panduan</h5>
                <p class="text-dark opacity-75 small mb-2">
                    - Pengaturan <strong>Rekening Bank</strong> yang Anda atur di sini akan langsung ditampilkan ke layar calon mahasiswa (CAMABA) di langkah ke-2 pada alur pendaftaran (setelah mereka mengisi form).
                </p>
                <p class="text-dark opacity-75 small mb-2">
                    - Calon Mahasiswa diwajibkan melakukan transfer ke rekening ini sebelum menekan tombol Kirim (Submit) Final.
                </p>
                <p class="text-dark opacity-75 small mb-0">
                    - Pengaturan <strong>Kontak</strong> akan digunakan pada tombol mengambang (Widget WhatsApp) yang ada di pojok kanan bawah halaman utama. Pastikan format nomor diawali dengan 62 (contoh: 628123...).
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
