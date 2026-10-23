@extends('layouts.admin')

@section('title', 'Banners Carousel')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color:#0F172A;">Banners Carousel</h4>
        <p class="text-muted mb-0" style="font-size:0.875rem;">Kelola gambar slide yang tampil di halaman utama website.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-4 rounded-3" data-bs-toggle="modal" data-bs-target="#addBannerModal" style="background:#4F46E5;border:none;">
        <i class="bi bi-plus-lg me-2"></i>Tambah Banner
    </button>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Grid Banner Cards --}}
@if($banners->isEmpty())
    <div class="admin-card text-center py-5">
        <i class="bi bi-images text-muted" style="font-size:3rem; opacity:0.4;"></i>
        <h6 class="mt-3 fw-semibold text-muted">Belum ada banner</h6>
        <p class="text-muted small mb-4">Klik tombol "Tambah Banner" untuk menambahkan slide pertama.</p>
        <button class="btn btn-primary btn-sm px-4 rounded-3" data-bs-toggle="modal" data-bs-target="#addBannerModal" style="background:#4F46E5;border:none;">
            <i class="bi bi-plus-lg me-1"></i>Tambah Banner
        </button>
    </div>
@else
    <div class="row g-4">
        @foreach($banners as $banner)
        <div class="col-md-6 col-xl-4">
            <div class="admin-card h-100 d-flex flex-column" style="overflow:hidden;">
                
                {{-- Preview Image --}}
                @php
                    $defaultThumbs = [
                        1 => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80',
                        2 => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80',
                        3 => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80',
                    ];
                    $thumbUrl = $banner->image ? asset('storage/' . $banner->image) : ($defaultThumbs[$banner->sort_order] ?? 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80');
                @endphp
                <div style="height:170px; position:relative; overflow:hidden; background:#0c0f1d; flex-shrink:0;">
                    <img src="{{ $thumbUrl }}" alt="{{ $banner->title }}"
                         style="width:100%; height:100%; object-fit:cover; opacity:0.8; transition:opacity 0.3s;">
                    
                    {{-- Gradient Overlay --}}
                    <div style="position:absolute;inset:0; background:linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 60%);"></div>
                    
                    {{-- Tema Badge --}}
                    <div style="position:absolute; top:12px; right:12px;">
                        <span class="badge px-3 py-1 rounded-pill fw-semibold"
                              style="background:{{ $banner->theme_color === 'navy' ? '#4F46E5' : ($banner->theme_color === 'green' ? '#059669' : '#D97706') }};
                                     color:white; font-size:0.7rem; letter-spacing:0.5px;">
                            {{ ucfirst($banner->theme_color) }}
                        </span>
                    </div>
                    
                    {{-- Sort Order --}}
                    <div style="position:absolute; top:12px; left:12px;">
                        <span class="badge bg-black bg-opacity-50 text-white rounded-pill px-2" style="font-size:0.7rem;">
                            #{{ $banner->sort_order }}
                        </span>
                    </div>
                    
                    {{-- Title on image --}}
                    <div style="position:absolute; bottom:0; left:0; right:0; padding:12px 14px;">
                        @if($banner->badge_text)
                            <span style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:rgba(255,255,255,0.7);">
                                {{ $banner->badge_text }}
                            </span>
                        @endif
                        <h6 class="text-white fw-bold mb-0" style="font-size:0.9rem; text-shadow:0 1px 3px rgba(0,0,0,0.5);">{{ $banner->title }}</h6>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-3 d-flex flex-column flex-grow-1">
                    @if($banner->description)
                        <p class="text-muted mb-3 flex-grow-1" style="font-size:0.8rem; line-height:1.5; display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $banner->description }}
                        </p>
                    @else
                        <div class="flex-grow-1"></div>
                    @endif

                    @if($banner->button_text)
                        <div class="mb-3">
                            <span style="font-size:0.72rem; color:#94a3b8;">Tombol:</span>
                            <span class="fw-semibold ms-1" style="font-size:0.8rem;">{{ $banner->button_text }}</span>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="d-flex gap-2 pt-3 border-top">
                        <button class="btn btn-sm fw-semibold rounded-3 flex-fill"
                                style="background:#EEF2FF;color:#4F46E5;border:none;font-size:0.8rem;"
                                onclick="openEditModal({{ $banner->id }}, '{{ addslashes($banner->title) }}', '{{ addslashes($banner->description ?? '') }}', '{{ $banner->theme_color }}', '{{ addslashes($banner->badge_text ?? '') }}', '{{ addslashes($banner->button_text ?? '') }}', '{{ addslashes($banner->button_link ?? '') }}')">
                            <i class="bi bi-pencil-square me-1"></i>Edit
                        </button>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?');">
                            @csrf
                            <button type="submit" class="btn btn-sm fw-semibold rounded-3"
                                    style="background:#FEF2F2;color:#DC2626;border:none;font-size:0.8rem;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif


{{-- ==============================
     MODAL TAMBAH BANNER
     ============================== --}}
<div class="modal fade" id="addBannerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Tambah Banner Baru</h5>
                    <p class="text-muted small mb-0">Slide ini akan tampil di halaman utama website.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                @include('admin.partials.banner-form')
            </div>
            <div class="modal-footer border-top px-4 pb-4 pt-3 gap-2">
                <button type="button" class="btn btn-light fw-semibold px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary fw-semibold px-5 rounded-3" style="background:#4F46E5;border:none;">
                    <i class="bi bi-cloud-arrow-up me-1"></i>Simpan Banner
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ==============================
     MODAL EDIT BANNER
     ============================== --}}
<div class="modal fade" id="editBannerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="editBannerForm" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Edit Banner</h5>
                    <p class="text-muted small mb-0">Ubah konten dan gambar banner yang sudah ada.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                @include('admin.partials.banner-form', ['isEdit' => true])
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
function openEditModal(id, title, description, themeColor, badgeText, buttonText, buttonLink) {
    const form = document.getElementById('editBannerForm');
    form.action = `/admin/banners/${id}/update`;
    
    form.querySelector('[name="title"]').value = title;
    form.querySelector('[name="description"]').value = description;
    form.querySelector('[name="badge_text"]').value = badgeText;
    form.querySelector('[name="button_text"]').value = buttonText;
    form.querySelector('[name="button_link"]').value = buttonLink;
    
    const themeSelect = form.querySelector('[name="theme_color"]');
    for (let opt of themeSelect.options) {
        opt.selected = (opt.value === themeColor);
    }
    
    const modal = new bootstrap.Modal(document.getElementById('editBannerModal'));
    modal.show();
}
</script>
@endpush
