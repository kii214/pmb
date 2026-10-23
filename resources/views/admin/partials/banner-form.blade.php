{{-- Shared form fields used in both Add and Edit banner modals --}}
<div class="row g-3">
    <div class="col-12">
        <label class="form-label fw-semibold small mb-1">
            Gambar Banner
            @if(isset($isEdit)) <span class="text-muted fw-normal">(Kosongkan jika tidak ingin mengganti)</span> @endif
        </label>
        <input type="file" name="image" class="form-control rounded-3" accept="image/*"
               style="border:1.5px dashed #CBD5E1; padding:10px;">
        <small class="text-muted">Rasio ideal: 16:9 (misal 1920×1080). Maks. 2MB.</small>
    </div>

    <div class="col-md-8">
        <label class="form-label fw-semibold small mb-1">Judul Banner <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control rounded-3" required
               placeholder="Contoh: Penerimaan Mahasiswa Baru 2025/2026">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold small mb-1">Tema Warna <span class="text-danger">*</span></label>
        <select name="theme_color" class="form-select rounded-3" required>
            <option value="navy">🔵 Biru (Navy)</option>
            <option value="green">🟢 Hijau Emerald</option>
            <option value="orange">🟠 Oranye</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold small mb-1">Deskripsi / Sub-judul</label>
        <textarea name="description" class="form-control rounded-3" rows="2"
                  placeholder="Teks penjelasan singkat yang akan tampil di bawah judul..."></textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold small mb-1">Teks Label Atas (Badge)</label>
        <input type="text" name="badge_text" class="form-control rounded-3"
               placeholder="Contoh: GELOMBANG 2">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold small mb-1">Teks Tombol</label>
        <input type="text" name="button_text" class="form-control rounded-3"
               placeholder="Contoh: Daftar Sekarang">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold small mb-1">Link Tombol</label>
        <input type="text" name="button_link" class="form-control rounded-3"
               placeholder="/pendaftaran">
    </div>
</div>
