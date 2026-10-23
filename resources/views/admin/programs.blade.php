@extends('layouts.admin')

@section('title', 'Program Studi')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color:#0F172A;">Program Studi</h4>
        <p class="text-muted mb-0" style="font-size:0.875rem;">Kelola data program studi beserta informasi kurikulum dan akreditasi resmi.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-4 rounded-3" data-bs-toggle="modal" data-bs-target="#addProgramModal" style="background:#4F46E5;border:none;">
        <i class="bi bi-plus-lg me-2"></i>Tambah Prodi
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Tabel Program Studi & Akreditasi --}}
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <div>
            <h6 class="admin-card-title">Daftar Program Studi & Akreditasi</h6>
            <p class="text-muted mb-0" style="font-size:0.78rem;">Klik tombol Edit untuk memperbarui informasi prodi & data akreditasi.</p>
        </div>
        <span class="badge bg-light text-dark border">{{ $programs->count() }} Program Studi</span>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="padding:12px 16px;">No</th>
                    <th style="padding:12px 16px;">Program Studi</th>
                    <th style="padding:12px 16px;">Jenjang</th>
                    <th style="padding:12px 16px;">No. SK Akreditasi</th>
                    <th style="padding:12px 16px; text-align:center;">Tahun SK</th>
                    <th style="padding:12px 16px; text-align:center;">Peringkat</th>
                    <th style="padding:12px 16px;">Status</th>
                    <th style="padding:12px 16px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programs as $program)
                <tr>
                    <td style="padding:14px 16px; color:#94A3B8; font-weight:600;">{{ $loop->iteration }}</td>
                    <td style="padding:14px 16px;">
                        <div class="fw-semibold" style="color:#0F172A;">{{ $program->name }}</div>

                    </td>
                    <td style="padding:14px 16px;">
                        <span class="status-badge {{ $program->level == 'S1' ? 'blue' : 'yellow' }}">
                            {{ $program->level == 'S1' ? 'Sarjana (S1)' : 'Diploma (D3)' }}
                        </span>
                    </td>
                    <td style="padding:14px 16px; font-size:0.82rem; color:#475569; max-width:220px;">
                        {{ $program->accreditation_sk_number ?? 'Belum diisi' }}
                    </td>
                    <td style="padding:14px 16px; text-align:center; font-weight:600;">
                        {{ $program->accreditation_year ?? '-' }}
                    </td>
                    <td style="padding:14px 16px; text-align:center;">
                        @php
                            $acc = $program->accreditation ?? '';
                            $cls = str_contains($acc, 'Baik Sekali') ? 'green' : (str_contains($acc, 'Baik') ? 'blue' : (str_contains($acc, 'C') ? 'yellow' : 'gray'));
                        @endphp
                        <span class="status-badge {{ $cls }}">{{ $acc ?: '-' }}</span>
                    </td>
                    <td style="padding:14px 16px;">
                        @if($program->status === 'active')
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill" style="font-size:0.72rem;">Aktif</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill" style="font-size:0.72rem;">Non-aktif</span>
                        @endif
                    </td>
                    <td style="padding:14px 16px; text-align:center;">
                        <div class="d-inline-flex gap-1">
                            <button class="btn btn-sm fw-semibold rounded-3"
                                    style="background:#EEF2FF;color:#4F46E5;border:none;font-size:0.8rem;"
                                    onclick="openEditProdi(
                                        {{ $program->id }},
                                        '{{ addslashes($program->name) }}',
                                        '{{ addslashes($program->code) }}',
                                        '{{ $program->level }}',
                                        '{{ $program->status }}',
                                        `{{ addslashes($program->description) }}`,
                                        '{{ addslashes($program->accreditation ?? '') }}',
                                        '{{ addslashes($program->accreditation_sk_number ?? '') }}',
                                        '{{ $program->accreditation_year ?? '' }}',
                                        '{{ $program->accreditation_valid_from?->format('Y-m-d') ?? '' }}',
                                        '{{ $program->accreditation_valid_until?->format('Y-m-d') ?? '' }}',
                                        '{{ addslashes($program->accreditation_certificate_url ?? '') }}'
                                    )">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </button>
                            <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus program studi {{ $program->name }}? Pastikan tidak ada pendaftar di prodi ini.');"
                                  class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" style="font-size:0.8rem;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH PRODI --}}
<div class="modal fade" id="addProgramModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.programs.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Tambah Program Studi Baru</h5>
                    <p class="text-muted small mb-0">Lengkapi semua kolom yang diperlukan.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold small mb-1">Nama Program Studi <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="Contoh: Teknik Informatika">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Jenjang <span class="text-danger">*</span></label>
                        <select name="level" class="form-select rounded-3" required>
                            <option value="S1">Sarjana (S1)</option>
                            <option value="D3">Diploma (D3)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Kode Prodi <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control rounded-3" required placeholder="Cth: 55201">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold small mb-1">Peringkat Akreditasi <span class="text-danger">*</span></label>
                        <select name="accreditation" class="form-select rounded-3" required>
                            <option value="Akreditasi Baik Sekali">Akreditasi Baik Sekali</option>
                            <option value="Akreditasi Baik">Akreditasi Baik</option>
                            <option value="Akreditasi C">Akreditasi C</option>
                            <option value="Terakreditasi">Terakreditasi</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small mb-1">No. SK Akreditasi</label>
                        <input type="text" name="accreditation_sk_number" class="form-control rounded-3" placeholder="Contoh: No. 180/SK/LAM-INFOKOM/Ak/S/XII/2023">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Tahun SK</label>
                        <input type="number" name="accreditation_year" class="form-control rounded-3" placeholder="2024" min="2000" max="2100">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Berlaku Dari</label>
                        <input type="date" name="accreditation_valid_from" class="form-control rounded-3">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Berlaku Sampai</label>
                        <input type="date" name="accreditation_valid_until" class="form-control rounded-3">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small mb-1">Link Unduh Sertifikat (URL)</label>
                        <input type="text" name="accreditation_certificate_url" class="form-control rounded-3" placeholder="https://laminfokom.id/sertifikat/...">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small mb-1">Deskripsi Program Studi <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control rounded-3" rows="3" required placeholder="Penjelasan profil dan prospek kerja program studi..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top px-4 pb-4 pt-3 gap-2">
                <button type="button" class="btn btn-light fw-semibold px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary fw-semibold px-5 rounded-3" style="background:#4F46E5;border:none;">
                    <i class="bi bi-plus-lg me-1"></i>Simpan Prodi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT LENGKAP PRODI --}}
<div class="modal fade" id="editProdiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="editProdiForm" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom px-4 pt-4 pb-3" style="background:#F8FAFC;">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="editProdiTitle">Edit Program Studi</h5>
                    <p class="text-muted small mb-0">Perbarui informasi prodi beserta data akreditasi resmi.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold small mb-1">Nama Program Studi <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Kode Prodi <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="edit_code" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Jenjang <span class="text-danger">*</span></label>
                        <select name="level" id="edit_level" class="form-select rounded-3" required>
                            <option value="S1">Sarjana (S1)</option>
                            <option value="D3">Diploma (D3)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Status Prodi</label>
                        <select name="status" id="edit_status" class="form-select rounded-3">
                            <option value="active">Aktif (Dibuka)</option>
                            <option value="inactive">Non-aktif (Ditutup)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Peringkat Akreditasi <span class="text-danger">*</span></label>
                        <select name="accreditation" id="edit_accreditation" class="form-select rounded-3" required>
                            <option value="Akreditasi Baik Sekali">Akreditasi Baik Sekali</option>
                            <option value="Akreditasi Baik">Akreditasi Baik</option>
                            <option value="Akreditasi C">Akreditasi C</option>
                            <option value="Terakreditasi">Terakreditasi</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small mb-1">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea name="description" id="edit_description" class="form-control rounded-3" rows="3" required></textarea>
                    </div>

                    <div class="col-12"><hr class="my-1 text-muted opacity-25"></div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold small mb-1">No. SK Akreditasi</label>
                        <input type="text" name="accreditation_sk_number" id="edit_sk_number" class="form-control rounded-3" placeholder="Contoh: No. 180/SK/LAM-INFOKOM/Ak/S/XII/2023">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Tahun SK</label>
                        <input type="number" name="accreditation_year" id="edit_year" class="form-control rounded-3" min="2000" max="2100">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small mb-1">Berlaku Dari</label>
                        <input type="date" name="accreditation_valid_from" id="edit_valid_from" class="form-control rounded-3">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small mb-1">Berlaku Sampai</label>
                        <input type="date" name="accreditation_valid_until" id="edit_valid_until" class="form-control rounded-3">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small mb-1">Link Unduh Sertifikat (URL PDF)</label>
                        <input type="text" name="accreditation_certificate_url" id="edit_cert_url" class="form-control rounded-3" placeholder="https://...">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top px-4 pb-4 pt-3 gap-2">
                <button type="button" class="btn btn-light fw-semibold px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary fw-semibold px-5 rounded-3" style="background:#4F46E5;border:none;">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditProdi(id, name, code, level, status, description, accreditation, skNumber, year, validFrom, validUntil, certUrl) {
    document.getElementById('editProdiTitle').textContent = 'Edit Program Studi — ' + name;
    document.getElementById('editProdiForm').action = `/admin/program-studi/${id}/update`;

    document.getElementById('edit_name').value = name;
    document.getElementById('edit_code').value = code;
    document.getElementById('edit_description').value = description;

    const levelSel = document.getElementById('edit_level');
    for (let opt of levelSel.options) opt.selected = (opt.value === level);

    const statusSel = document.getElementById('edit_status');
    for (let opt of statusSel.options) opt.selected = (opt.value === status);

    const accSel = document.getElementById('edit_accreditation');
    for (let opt of accSel.options) opt.selected = (opt.value === accreditation);

    document.getElementById('edit_sk_number').value  = skNumber;
    document.getElementById('edit_year').value        = year;
    document.getElementById('edit_valid_from').value  = validFrom;
    document.getElementById('edit_valid_until').value = validUntil;
    document.getElementById('edit_cert_url').value    = certUrl;

    new bootstrap.Modal(document.getElementById('editProdiModal')).show();
}
</script>
@endpush
