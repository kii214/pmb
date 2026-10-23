@extends('layouts.admin')

@section('title', 'Alur Pendaftaran')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color:#0F172A;">Alur Pendaftaran</h4>
        <p class="text-muted mb-0" style="font-size:0.875rem;">Kelola langkah-langkah tahapan alur pendaftaran PMB yang ditampilkan pada calon mahasiswa.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-4 rounded-3 d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#addStepModal"
            style="background:#4F46E5;border:none;">
        <i class="bi bi-plus-lg"></i> Tambah Tahapan
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h6 class="admin-card-title">Daftar Langkah Alur PMB</h6>
            <p class="text-muted mb-0" style="font-size:0.78rem;">Urutan langkah ditampilkan secara berurutan sesuai nomor urutan.</p>
        </div>
        <span class="badge bg-light text-dark border">{{ $steps->count() }} Tahapan</span>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 70px; text-align: center;">Urutan</th>
                    <th style="width: 70px; text-align: center;">Ikon</th>
                    <th>Nama Tahap</th>
                    <th>Deskripsi</th>
                    <th style="width: 110px; text-align: center;">Status</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($steps as $step)
                <tr>
                    <td style="text-align: center; font-weight: 700; color: #4F46E5;">
                        <span class="badge bg-indigo-subtle text-indigo rounded-pill px-3 py-2" style="background:#EEF2FF; color:#4F46E5;">
                            #{{ $step->sort_order ?? $loop->iteration }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-light text-primary" style="width: 40px; height: 40px; font-size: 1.25rem;">
                            <i class="bi {{ $step->icon ?: 'bi-check2-circle' }}"></i>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $step->name }}</div>
                        <code class="text-muted small">{{ $step->icon }}</code>
                    </td>
                    <td style="max-width: 340px; color: #64748B; font-size: 0.85rem; line-height: 1.5;">
                        {{ $step->description }}
                    </td>
                    <td style="text-align: center;">
                        @if($step->status === 'active')
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                                <i class="bi bi-check-circle-fill me-1"></i> Aktif
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                                Non-aktif
                            </span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <div class="d-inline-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editStepModal{{ $step->id }}"
                                    title="Edit Tahapan">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.steps.destroy', $step->id) }}" method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus tahapan ini?');" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- MODAL EDIT STEP --}}
                <div class="modal fade" id="editStepModal{{ $step->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="{{ route('admin.steps.update', $step->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                            @csrf
                            <div class="modal-header border-bottom-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit Tahapan Alur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-muted">Nama Tahap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $step->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-muted">Deskripsi / Instruksi <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ $step->description }}</textarea>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-7">
                                        <label class="form-label fw-semibold small text-muted">Bootstrap Icon Class</label>
                                        <input type="text" name="icon" class="form-control" value="{{ $step->icon }}" placeholder="Cth: bi-file-earmark-text" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold small text-muted">Nomor Urutan</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{ $step->sort_order }}" min="1">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold small text-muted">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ $step->status === 'active' ? 'selected' : '' }}>Aktif (Tampil di Landing Page)</option>
                                        <option value="inactive" {{ $step->status === 'inactive' ? 'selected' : '' }}>Non-aktif (Disembunyikan)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary px-4" style="background:#4F46E5;border:none;">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        Belum ada tahapan alur pendaftaran. Klik "Tambah Tahapan" untuk menambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH STEP --}}
<div class="modal fade" id="addStepModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.steps.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Tahapan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Nama Tahap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Cth: Mengisi Formulir Online" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Deskripsi / Penjelasan Singkat <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan apa yang harus dilakukan calon mahasiswa pada tahap ini..." required></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold small text-muted">Bootstrap Icon</label>
                        <input type="text" name="icon" class="form-control" value="bi-check2-circle" placeholder="Cth: bi-file-text, bi-cash-stack, dll." required>
                        <small class="text-muted" style="font-size:0.75rem;">Pilihan umum: bi-globe, bi-cursor-fill, bi-file-earmark-text-fill, bi-headset, bi-cash-stack</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" selected>Aktif</option>
                            <option value="inactive">Non-aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4" style="background:#4F46E5;border:none;">Tambah Tahap</button>
            </div>
        </form>
    </div>
</div>
@endsection
