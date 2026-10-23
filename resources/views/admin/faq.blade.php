@extends('layouts.admin')

@section('title', 'Manajemen FAQ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color:#0F172A;">Pertanyaan Umum (FAQ)</h4>
        <p class="text-muted mb-0" style="font-size:0.875rem;">Kelola daftar tanya-jawab seputar PMB yang tampil di accordion halaman utama.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-4 rounded-3 d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#addFaqModal"
            style="background:#4F46E5;border:none;">
        <i class="bi bi-plus-lg"></i> Tambah FAQ
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
            <h6 class="admin-card-title">Daftar FAQ PMB</h6>
            <p class="text-muted mb-0" style="font-size:0.78rem;">FAQ aktif akan muncul di section accordion bagian bawah landing page.</p>
        </div>
        <span class="badge bg-light text-dark border">{{ $faqs->count() }} Pertanyaan</span>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 70px; text-align: center;">Urutan</th>
                    <th style="width: 320px;">Pertanyaan</th>
                    <th>Jawaban</th>
                    <th style="width: 110px; text-align: center;">Status</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                <tr>
                    <td style="text-align: center; font-weight: 700;">
                        <span class="badge bg-indigo-subtle text-indigo rounded-pill px-3 py-2" style="background:#EEF2FF; color:#4F46E5;">
                            #{{ $faq->sort_order ?? $loop->iteration }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark fs-6">{{ $faq->question }}</div>
                    </td>
                    <td style="color: #64748B; font-size: 0.85rem; line-height: 1.6;">
                        <div style="max-height: 80px; overflow-y: auto;">
                            {{ $faq->answer }}
                        </div>
                    </td>
                    <td style="text-align: center;">
                        @if($faq->status === 'active')
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
                                    data-bs-target="#editFaqModal{{ $faq->id }}"
                                    title="Edit FAQ">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- MODAL EDIT FAQ --}}
                <div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                            @csrf
                            <div class="modal-header border-bottom-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit Tanya Jawab (FAQ)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-muted">Pertanyaan <span class="text-danger">*</span></label>
                                    <input type="text" name="question" class="form-control" value="{{ $faq->question }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-muted">Jawaban Lengkap <span class="text-danger">*</span></label>
                                    <textarea name="answer" class="form-control" rows="5" required>{{ $faq->answer }}</textarea>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">Nomor Urutan Tampil</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{ $faq->sort_order }}" min="1">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="active" {{ $faq->status === 'active' ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                                            <option value="inactive" {{ $faq->status === 'inactive' ? 'selected' : '' }}>Non-aktif (Disembunyikan)</option>
                                        </select>
                                    </div>
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
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-question-circle fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        Belum ada data FAQ. Klik "Tambah FAQ" untuk menambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH FAQ --}}
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.faq.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah FAQ Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Pertanyaan <span class="text-danger">*</span></label>
                    <input type="text" name="question" class="form-control" placeholder="Cth: Apakah ada program beasiswa KIP Kuliah di STMIK ROSMA?" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Jawaban Lengkap <span class="text-danger">*</span></label>
                    <textarea name="answer" class="form-control" rows="5" placeholder="Tuliskan jawaban yang ramah, jelas, dan informatif bagi calon pendaftar..." required></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label fw-semibold small text-muted">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" selected>Aktif (Langsung tampil di website)</option>
                        <option value="inactive">Non-aktif (Draft)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4" style="background:#4F46E5;border:none;">Tambah FAQ</button>
            </div>
        </form>
    </div>
</div>
@endsection
