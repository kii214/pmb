@extends('layouts.admin')

@section('title', $program->name . ' — ' . $wave->name)

@push('styles')
<style>
/* ===== LAYOUT ===== */
.page-split {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 28px;
    align-items: start;
}
@media(max-width:992px){ .page-split{ grid-template-columns:1fr; } }

/* ===== FEE TABLE ===== */
.fee-table-wrap {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    overflow: hidden;
}
.fee-table-wrap table { margin-bottom:0; }
.fee-table-wrap thead th {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    color: #64748b;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 14px 20px;
}
.fee-table-wrap tbody td {
    padding: 16px 20px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: .875rem;
    color: #334155;
}
.fee-table-wrap tbody tr:last-child td { border-bottom: none; }
.fee-table-wrap tbody tr:hover td { background: #fafbff; }

/* ===== TYPE PILL ===== */
.type-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: .7rem;
    font-weight: 700;
}
.pill-reg  { background: #fef3c7; color: #92400e; }
.pill-ukt  { background: #e0e7ff; color: #3730a3; }

/* ===== STICKY FORM CARD ===== */
.form-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    position: sticky;
    top: 80px;
}
.form-card-header {
    padding: 20px 24px 0;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 16px;
}
.form-card-body { padding: 20px 24px; }
.form-card-footer { padding: 0 24px 20px; }

/* ===== INFO BANNER ===== */
.info-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: .75rem;
    color: #1e40af;
    font-weight: 500;
}

/* ===== EMPTY STATE ===== */
.empty-state {
    padding: 60px 24px;
    text-align: center;
    color: #94a3b8;
}

/* ===== EDIT ROW ===== */
.edit-row-fields { display: none; }
.tr-edit-mode .normal-fields { display: none; }
.tr-edit-mode .edit-row-fields { display: table-cell; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb" style="font-size:.84rem;">
        <li class="breadcrumb-item"><a href="{{ route('admin.fees') }}" class="text-decoration-none text-muted">Biaya & Voucher</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.fees.show', $wave->id) }}" class="text-decoration-none text-muted">{{ $wave->name }}</a></li>
        <li class="breadcrumb-item active fw-semibold text-dark">{{ $program->name }}</li>
    </ol>
</nav>

{{-- Header --}}
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">{{ $program->name }}</h3>
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <span class="text-muted" style="font-size:.84rem;">
                <i class="bi bi-layers text-primary me-1"></i>{{ $wave->name }}
            </span>
            <span class="text-muted" style="font-size:.84rem;">
                <i class="bi bi-calendar-range text-primary me-1"></i>
                {{ $wave->start_date->format('d M Y') }} — {{ $wave->end_date->format('d M Y') }}
            </span>
            <span class="text-muted" style="font-size:.84rem;">
                <i class="bi bi-mortarboard text-primary me-1"></i> T.A. {{ $wave->academic_year }}
            </span>
        </div>
    </div>
    <a href="{{ route('admin.fees.show', $wave->id) }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

{{-- Alert --}}
@if(session('success'))
<div class="alert alert-success border-0 rounded-3 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
    <i class="bi bi-check-circle-fill text-success"></i>
    <span>{{ session('success') }}</span>
    <button type="button" class="btn-close ms-auto btn-sm" data-bs-dismiss="alert"></button>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    {{ $errors->first() }}
</div>
@endif

{{-- Info chips --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <span class="info-chip"><i class="bi bi-award-fill"></i> Biaya Registrasi sudah termasuk Jas Almamater</span>
    <span class="info-chip"><i class="bi bi-building-fill"></i> Free Uang Gedung</span>
    <span class="info-chip"><i class="bi bi-camera-video-fill"></i> Free Seminar 1 Tahun</span>
</div>

{{-- Two-column split --}}
<div class="page-split">

    {{-- LEFT — Tabel Biaya --}}
    <div>
        <div class="fee-table-wrap">
            <div class="d-flex justify-content-between align-items-center px-5 py-3 border-bottom">
                <div>
                    <h6 class="fw-bold mb-0">Rincian Biaya Semester</h6>
                    <p class="text-muted mb-0" style="font-size:.78rem;">{{ $fees->count() }} komponen terdaftar</p>
                </div>
                @php $totalAmount = $fees->sum('amount'); @endphp
                <div class="text-end">
                    <div class="text-muted" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.5px;">Total / Semester</div>
                    <div class="fw-bold text-success" style="font-size:1.1rem;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                </div>
            </div>

            @if($fees->isEmpty())
            <div class="empty-state">
                <i class="bi bi-inbox-fill" style="font-size:3rem; opacity:.3; display:block; margin-bottom:12px;"></i>
                <h6 class="fw-semibold text-dark">Belum ada komponen biaya</h6>
                <p class="mb-0 small">Isi form di kanan untuk menambahkan biaya UKT, Registrasi, dll.</p>
            </div>
            @else
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="40" class="text-center">#</th>
                        <th>Komponen Biaya</th>
                        <th>Jalur</th>
                        <th class="text-end">Nominal</th>
                        <th class="text-center" width="110">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $fee)
                    @php
                        $isReg = stripos($fee->name,'registrasi') !== false || stripos($fee->name,'pendaftaran') !== false;
                    @endphp
                    <tr id="row-{{ $fee->id }}">

                        {{-- Normal mode --}}
                        <td class="text-center text-muted fw-semibold normal-fields">{{ $loop->iteration }}</td>
                        <td class="normal-fields">
                            <div class="fw-semibold text-dark" style="font-size:.88rem;">{{ $fee->name }}</div>
                            <span class="type-pill mt-1 {{ $isReg ? 'pill-reg' : 'pill-ukt' }}">
                                <i class="bi {{ $isReg ? 'bi-receipt' : 'bi-cash-stack' }}"></i>
                                {{ $isReg ? 'Pendaftaran' : 'UKT / Tahapan' }}
                            </span>
                        </td>
                        <td class="text-muted normal-fields" style="font-size:.82rem;">
                            {{ $fee->path->name ?? '—' }}
                        </td>
                        <td class="text-end normal-fields">
                            <span class="fw-bold text-success" style="font-size:1rem;">Rp {{ number_format($fee->amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="text-center normal-fields">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-2 me-1"
                                    onclick="enableEdit({{ $fee->id }})" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.fees.destroy', $fee->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus biaya ini?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>

                        {{-- Edit mode (hidden by default, spans full row) --}}
                        <td class="edit-row-fields" colspan="5">
                            <form action="{{ route('admin.fees.update', $fee->id) }}" method="POST">
                                @csrf
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label mb-1" style="font-size:.75rem; font-weight:600; color:#64748b;">NAMA KOMPONEN</label>
                                        <select class="form-select form-select-sm" onchange="handleEditSelect(this)">
                                            @php
                                                $presets = ['Biaya Registrasi / Pendaftaran','UKT Tahap 1','UKT Tahap 2','UKT Tahap 3','UKT Tahap 4','UKT Tahap 5','UKT Tahap 6','Biaya Lainnya'];
                                                $isPreset = in_array($fee->name, $presets);
                                            @endphp
                                            @foreach($presets as $p)
                                                <option value="{{ $p }}" {{ $fee->name == $p ? 'selected' : '' }}>{{ $p }}</option>
                                            @endforeach
                                            <option value="_custom" {{ !$isPreset ? 'selected' : '' }}>Ketik sendiri...</option>
                                        </select>
                                        <input type="text" class="form-control form-control-sm mt-1 {{ $isPreset ? 'd-none' : '' }}"
                                               id="edit-custom-{{ $fee->id }}"
                                               value="{{ !$isPreset ? $fee->name : '' }}"
                                               oninput="document.getElementById('edit-name-final-{{ $fee->id }}').value = this.value"
                                               placeholder="Nama komponen...">
                                        <input type="hidden" id="edit-name-final-{{ $fee->id }}" name="name" value="{{ $fee->name }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label mb-1" style="font-size:.75rem; font-weight:600; color:#64748b;">NOMINAL (RP)</label>
                                        <input type="number" name="amount" class="form-control form-control-sm"
                                               value="{{ intval($fee->amount) }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label mb-1" style="font-size:.75rem; font-weight:600; color:#64748b;">JALUR</label>
                                        <select name="registration_path_id" class="form-select form-select-sm">
                                            @foreach($paths as $p)
                                                <option value="{{ $p->id }}" {{ $fee->registration_path_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex gap-1">
                                        <button type="submit" class="btn btn-primary btn-sm flex-fill rounded-2">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm flex-fill rounded-2"
                                                onclick="cancelEdit({{ $fee->id }})">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#f8fafc;">
                        <td colspan="3" class="fw-semibold text-muted px-5" style="font-size:.8rem;">TOTAL SEMUA KOMPONEN</td>
                        <td class="text-end fw-bold text-success px-5" style="font-size:1rem;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            @endif
        </div>
    </div>

    {{-- RIGHT — Form Tambah --}}
    <div>
        <div class="form-card">
            <div class="form-card-header">
                <h6 class="fw-bold mb-1"><i class="bi bi-plus-circle text-primary me-2"></i>Tambah Komponen Biaya</h6>
                <p class="text-muted mb-0" style="font-size:.78rem;">Isi form untuk menambah biaya baru ke gelombang ini.</p>
            </div>
            <form action="{{ route('admin.fees.store') }}" method="POST">
                @csrf
                <input type="hidden" name="registration_wave_id" value="{{ $wave->id }}">
                <input type="hidden" name="program_study_id" value="{{ $program->id }}">
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.82rem;">Nama Komponen</label>
                        <select class="form-select" id="addNameSelect" style="font-size:.85rem;">
                            <option value="Biaya Registrasi / Pendaftaran">Biaya Registrasi / Pendaftaran</option>
                            <option value="UKT Tahap 1">UKT Tahap 1</option>
                            <option value="UKT Tahap 2">UKT Tahap 2</option>
                            <option value="UKT Tahap 3">UKT Tahap 3</option>
                            <option value="UKT Tahap 4">UKT Tahap 4</option>
                            <option value="UKT Tahap 5">UKT Tahap 5</option>
                            <option value="UKT Tahap 6">UKT Tahap 6</option>
                            <option value="Biaya Lainnya">Biaya Lainnya</option>
                            <option value="_custom">✏️ Ketik sendiri...</option>
                        </select>
                        <input type="text" id="addNameCustom" class="form-control mt-2 d-none"
                               placeholder="Contoh: Biaya Praktikum..." style="font-size:.85rem;">
                        <input type="hidden" id="addNameFinal" name="name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.82rem;">Nominal (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.85rem; background:#f8fafc;">Rp</span>
                            <input type="number" name="amount" class="form-control" min="0" placeholder="0" required style="font-size:.9rem;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:.82rem;">Jalur Pendaftaran</label>
                        <select name="registration_path_id" class="form-select" required style="font-size:.85rem;">
                            @foreach($paths as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Preset helper chips --}}
                    <div class="mb-3">
                        <div class="text-muted mb-2" style="font-size:.72rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px;">Pilih Cepat</div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(['Biaya Registrasi / Pendaftaran','UKT Tahap 1','UKT Tahap 2','UKT Tahap 3','UKT Tahap 4','UKT Tahap 5','UKT Tahap 6'] as $preset)
                            <button type="button" class="btn btn-sm rounded-pill border text-muted preset-chip"
                                    style="font-size:.72rem; padding:3px 10px;"
                                    onclick="setPreset('{{ $preset }}')">
                                {{ $preset }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-card-footer">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 fw-semibold py-2">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Biaya
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// ===== ADD FORM =====
const addSel    = document.getElementById('addNameSelect');
const addCustom = document.getElementById('addNameCustom');
const addFinal  = document.getElementById('addNameFinal');

function syncAdd() {
    if (addSel.value === '_custom') {
        addCustom.classList.remove('d-none');
        addCustom.required = true;
        addFinal.value = addCustom.value;
    } else {
        addCustom.classList.add('d-none');
        addCustom.required = false;
        addFinal.value = addSel.value;
    }
}
addSel.removeAttribute('name');
addSel.addEventListener('change', syncAdd);
addCustom.addEventListener('input', () => { addFinal.value = addCustom.value; });

// Preset quick chips
function setPreset(name) {
    addSel.value = name;
    syncAdd();
    // Highlight selected chip
    document.querySelectorAll('.preset-chip').forEach(b => {
        b.classList.toggle('btn-primary', b.textContent.trim() === name);
        b.classList.toggle('text-white', b.textContent.trim() === name);
        b.classList.toggle('border-primary', b.textContent.trim() === name);
        b.classList.toggle('text-muted', b.textContent.trim() !== name);
    });
}

// Init
syncAdd();

// ===== EDIT ROW =====
function enableEdit(id) {
    const row = document.getElementById('row-' + id);
    row.classList.add('tr-edit-mode');
    row.querySelectorAll('.normal-fields').forEach(td => td.style.display = 'none');
    row.querySelectorAll('.edit-row-fields').forEach(td => { td.style.display = 'table-cell'; });
}

function cancelEdit(id) {
    const row = document.getElementById('row-' + id);
    row.classList.remove('tr-edit-mode');
    row.querySelectorAll('.normal-fields').forEach(td => td.style.display = '');
    row.querySelectorAll('.edit-row-fields').forEach(td => { td.style.display = ''; });
}

function handleEditSelect(sel) {
    const id = sel.closest('tr').id.split('-')[1];
    const customInput = document.getElementById('edit-custom-' + id);
    const finalInput  = document.getElementById('edit-name-final-' + id);
    if (sel.value === '_custom') {
        customInput.classList.remove('d-none');
        customInput.required = true;
        finalInput.value = customInput.value;
        sel.removeAttribute('name');
    } else {
        customInput.classList.add('d-none');
        customInput.required = false;
        finalInput.value = sel.value;
        sel.removeAttribute('name');
    }
}

// Init edit selects
document.querySelectorAll('.edit-row-fields select[id^="edit-"]').forEach(sel => {
    // remove name from select; hidden input carries the value
});
</script>
@endpush
