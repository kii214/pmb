@extends('layouts.admin')

@section('title', 'Detail Pendaftar - ' . $application->application_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.applicants.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pendaftar
        </a>
        <h3 class="fw-bold mb-1">Detail Pendaftar</h3>
        <p class="text-muted mb-0">No. Pendaftaran: <span class="badge bg-primary">{{ $application->application_number }}</span></p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.applicants.delete', $application) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftar ini secara permanen?');">
            @csrf
            <button type="submit" class="btn btn-outline-danger d-flex align-items-center gap-2">
                <i class="bi bi-trash"></i> Hapus Data
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        {{-- DATA PRIBADI --}}
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i>Data Pribadi</h6>
            </div>
            <div class="admin-card-body">
                @php $fd = $application->form_data ?? []; @endphp
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Nama Lengkap</label>
                        <div class="fw-bold text-dark">{{ $fd['full_name'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">NIK (Nomor Induk Kependudukan)</label>
                        <div class="fw-bold text-dark">{{ $fd['nik'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Tempat, Tanggal Lahir</label>
                        <div class="fw-bold text-dark">
                            {{ $fd['birth_place'] ?? '-' }}, 
                            {{ isset($fd['birth_date']) ? \Carbon\Carbon::parse($fd['birth_date'])->format('d F Y') : '-' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Jenis Kelamin</label>
                        <div class="fw-bold text-dark">
                            {{ ($fd['gender'] ?? '') == 'L' ? 'Laki-laki' : (($fd['gender'] ?? '') == 'P' ? 'Perempuan' : '-') }}
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <h6 class="fw-bold mb-3 small text-uppercase text-muted">Informasi Kontak & Alamat</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Alamat Email</label>
                        <div>
                            <a href="mailto:{{ $fd['email'] ?? '' }}" class="fw-bold text-primary text-decoration-none">
                                <i class="bi bi-envelope me-1"></i>{{ $fd['email'] ?? '-' }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">No. WhatsApp</label>
                        <div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $fd['phone'] ?? '') }}" target="_blank" class="fw-bold text-success text-decoration-none">
                                <i class="bi bi-whatsapp me-1"></i>{{ $fd['phone'] ?? '-' }}
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small mb-1">Alamat Lengkap</label>
                        <div class="fw-bold text-dark">{{ $fd['address'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Kota/Kabupaten</label>
                        <div class="fw-bold text-dark">{{ $fd['city'] ?? '-' }}</div>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <h6 class="fw-bold mb-3 small text-uppercase text-muted">Riwayat Pendidikan</h6>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label text-muted small mb-1">Asal Sekolah</label>
                        <div class="fw-bold text-dark">{{ $fd['school_name'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Jurusan</label>
                        <div class="fw-bold text-dark">{{ $fd['major'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Tahun Lulus</label>
                        <div class="fw-bold text-dark">{{ $fd['graduation_year'] ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- STATUS & SELEKSI --}}
        <div class="admin-card mb-4 border-top border-4 border-primary">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="bi bi-gear-fill text-primary me-2"></i>Update Status</h6>
            </div>
            <div class="admin-card-body bg-light rounded-bottom">
                
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Pilihan Program Studi 1 (Utama)</label>
                    <div class="fw-bold text-dark fs-6">{{ $application->programStudy?->name ?? 'Tidak diketahui' }} ({{ $application->programStudy?->level ?? '' }})</div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small mb-1">Pilihan Program Studi 2 (Cadangan)</label>
                    <div class="fw-semibold text-dark">{{ $application->programStudy2 ? ($application->programStudy2->name . ' (' . $application->programStudy2->level . ')') : '-' }}</div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label text-muted small mb-1">Jalur Pendaftaran</label>
                    <div class="fw-bold text-dark">{{ $application->registrationPath?->name ?? 'Tidak diketahui' }}</div>
                </div>

                @if($application->payment_proof)
                <hr class="my-3 text-muted opacity-25">
                <div class="mb-4 text-center">
                    <label class="form-label text-muted small mb-2 d-block">Bukti Pembayaran</label>
                    <a href="{{ asset('storage/' . $application->payment_proof) }}" target="_blank">
                        <img src="{{ asset('storage/' . $application->payment_proof) }}" alt="Bukti TF" class="img-fluid rounded border shadow-sm" style="max-height: 200px; object-fit: contain;">
                    </a>
                    <small class="text-muted d-block mt-2"><i class="bi bi-zoom-in me-1"></i>Klik gambar untuk memperbesar</small>
                </div>
                @endif

                <hr class="my-3 text-muted opacity-25">

                <form action="{{ route('admin.applicants.status', $application) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Pendaftar</label>
                        <select name="status" class="form-select border-primary shadow-sm">
                            <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi (Submitted)</option>
                            <option value="verified" {{ $application->status == 'verified' ? 'selected' : '' }}>Diverifikasi (Berkas Lengkap)</option>
                            <option value="waitlisted" {{ $application->status == 'waitlisted' ? 'selected' : '' }}>Masuk Daftar Tunggu (Waitlist)</option>
                            <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Diterima (Lulus)</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Ditolak (Tidak Lulus)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Catatan Admin (Opsional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Tambahkan catatan internal terkait pendaftar ini...">{{ $application->admin_notes }}</textarea>
                        <small class="text-muted d-block mt-1">Catatan ini hanya dapat dilihat oleh Admin.</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan Status
                    </button>
                </form>

            </div>
        </div>

        {{-- INFO AKUN --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="bi bi-shield-lock-fill text-muted me-2"></i>Informasi Akun User</h6>
            </div>
            <div class="admin-card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-secondary-subtle p-3 rounded-circle d-flex justify-content-center align-items-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-person text-secondary fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ $application->user?->name ?? 'User Terhapus' }}</div>
                        <div class="text-muted small">Terdaftar sejak: {{ $application->user?->created_at?->format('d M Y') ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
