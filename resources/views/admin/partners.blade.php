@extends('layouts.admin')

@section('title', 'Manajemen Logo Mitra')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color:#0F172A;">Daftar Logo Mitra & Kerjasama</h4>
        <p class="text-muted mb-0" style="font-size:0.875rem;">Kelola logo mitra industri dan instansi yang ditampilkan pada bagian kemitraan landing page.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-4 rounded-3 d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#addPartnerModal"
            style="background:#4F46E5;border:none;">
        <i class="bi bi-plus-lg"></i> Tambah Mitra
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    @forelse($partners as $partner)
    <div class="col-md-6 col-xl-3">
        <div class="admin-card h-100 d-flex flex-column overflow-hidden">
            <div style="height:140px; background:#f8fafc; position:relative; border-bottom:1px solid #f1f5f9" class="d-flex align-items-center justify-content-center p-3">
                @if($partner->image)
                    <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" style="max-width:100%; max-height:100%; object-fit:contain;">
                @else
                    <div style="color:rgba(0,0,0,0.2);"><i class="bi bi-building fs-1"></i></div>
                @endif
                <span class="badge {{ $partner->is_active ? 'bg-success' : 'bg-secondary' }} position-absolute top-0 end-0 m-2 rounded-pill px-2 py-1" style="font-size:0.7rem;">
                    {{ $partner->is_active ? 'Aktif' : 'Non-aktif' }}
                </span>
            </div>
            <div class="admin-card-body d-flex flex-column flex-grow-1 p-3">
                <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $partner->name }}">{{ $partner->name }}</h6>
                <div class="text-muted small mb-3">Urutan: #{{ $partner->order ?? $loop->iteration }}</div>
                
                <div class="d-flex justify-content-between align-items-center pt-2 mt-auto border-top">
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3"
                            data-bs-toggle="modal"
                            data-bs-target="#editPartnerModal{{ $partner->id }}">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </button>
                    <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mitra ini?');">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT MITRA --}}
    <div class="modal fade" id="editPartnerModal{{ $partner->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small text-muted mb-1">Nama Mitra <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $partner->name }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small text-muted mb-1">Ganti Gambar Logo (Opsional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah logo saat ini.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-1">Nomor Urutan</label>
                            <input type="number" name="order" class="form-control" value="{{ $partner->order }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-1">Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ $partner->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$partner->is_active ? 'selected' : '' }}>Non-aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" style="background:#4F46E5;border:none;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="bi bi-building fs-1 d-block mb-2 text-secondary opacity-50"></i>
        Belum ada mitra terdaftar. Klik "Tambah Mitra" untuk menambahkan logo mitra kerjasama.
    </div>
    @endforelse
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addPartnerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Mitra Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis d-flex gap-3 align-items-center rounded-3">
                    <i class="bi bi-info-circle-fill fs-4"></i>
                    <div>
                        <strong class="d-block">Tips Gambar:</strong>
                        Disarankan mengunggah logo berformat PNG transparan resolusi tajam.
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold small text-muted mb-1">Nama Mitra <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: APTIKOM / PT Astra Honda Motor">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold small text-muted mb-1">Gambar Logo (Opsional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4" style="background:#4F46E5;border:none;">Simpan Mitra</button>
            </div>
        </form>
    </div>
</div>
@endsection
