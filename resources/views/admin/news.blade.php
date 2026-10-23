@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1 text-dark"><i class="bi bi-newspaper text-primary me-2"></i>Manajemen Berita</h3>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Kelola berita, artikel, dan pengumuman PMB.</p>
    </div>
    <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-4 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addNewsModal" style="font-weight: 500;">
        <i class="bi bi-plus-lg"></i> Tambah Berita
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-header d-flex justify-content-between align-items-center">
        <h6 class="admin-card-title mb-0">Daftar Berita & Artikel</h6>
    </div>
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th width="80">Gambar</th>
                    <th>Judul & Kategori</th>
                    <th>Ringkasan</th>
                    <th>Tanggal Publikasi</th>
                    <th class="text-center" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    <tr>
                        <td>
                            @if($item->image)
                                <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="Gambar Berita" class="rounded-3 object-fit-cover shadow-sm" style="width: 60px; height: 60px;">
                            @else
                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center text-muted border shadow-sm" style="width: 60px; height: 60px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-1">{{ $item->title }}</div>
                            <span class="badge bg-light text-dark border">{{ $item->category ?? 'Umum' }}</span>
                        </td>
                        <td>
                            <p class="text-muted mb-0 text-truncate" style="max-width: 250px; font-size: 0.85rem;">{{ $item->excerpt }}</p>
                        </td>
                        <td>
                            <div class="text-dark fw-medium" style="font-size: 0.85rem;">{{ $item->published_at->format('d M Y') }}</div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1" data-bs-toggle="modal" data-bs-target="#editNewsModal{{ $item->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#deleteNewsModal{{ $item->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editNewsModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header border-bottom-0 pb-0">
                                    <h5 class="modal-title fw-bold">Edit Berita</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.news.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body p-4">
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label class="form-label fw-semibold">Judul Berita</label>
                                                <input type="text" name="title" class="form-control form-control-lg" value="{{ $item->title }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Kategori</label>
                                                <select name="category" class="form-select form-control-lg">
                                                    <option value="Umum" {{ $item->category == 'Umum' ? 'selected' : '' }}>Umum</option>
                                                    <option value="Pengumuman" {{ $item->category == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                                    <option value="Berita Utama" {{ $item->category == 'Berita Utama' ? 'selected' : '' }}>Berita Utama</option>
                                                    <option value="Artikel" {{ $item->category == 'Artikel' ? 'selected' : '' }}>Artikel</option>
                                                    <option value="Kegiatan Kampus" {{ $item->category == 'Kegiatan Kampus' ? 'selected' : '' }}>Kegiatan Kampus</option>
                                                    <option value="Beasiswa" {{ $item->category == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Gambar/Thumbnail (Opsional)</label>
                                                <input type="file" name="image" class="form-control form-control-lg" accept="image/*">
                                                <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Ringkasan (Maks 500 karakter)</label>
                                                <textarea name="excerpt" class="form-control" rows="2" required>{{ $item->excerpt }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Konten Lengkap</label>
                                                <textarea name="content" class="form-control" rows="6" required>{{ $item->content }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteNewsModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title fw-bold text-danger">Hapus Berita?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-4">
                                    <p class="mb-0">Apakah Anda yakin ingin menghapus berita <strong>"{{ $item->title }}"</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                                <div class="modal-footer border-top-0">
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-newspaper fs-1 d-block mb-3 opacity-25"></i>
                            Belum ada berita yang dipublikasikan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Judul Berita</label>
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Masukkan judul berita..." required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="category" class="form-select form-control-lg">
                                <option value="Umum">Umum</option>
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Berita Utama">Berita Utama</option>
                                <option value="Artikel">Artikel</option>
                                <option value="Kegiatan Kampus">Kegiatan Kampus</option>
                                <option value="Beasiswa">Beasiswa</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Gambar/Thumbnail (Opsional)</label>
                            <input type="file" name="image" class="form-control form-control-lg" accept="image/*">
                            <small class="text-muted d-block mt-1">Jika tidak diisi, sistem akan otomatis membuatkan gambar abstrak menarik untuk Anda.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ringkasan (Maks 500 karakter)</label>
                            <textarea name="excerpt" class="form-control" rows="2" placeholder="Tuliskan ringkasan singkat tentang berita ini..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Konten Lengkap</label>
                            <textarea name="content" class="form-control" rows="6" placeholder="Tuliskan isi lengkap berita..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Publikasikan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
