{{-- ===================== BERITA & PENGUMUMAN ===================== --}}
<section class="section-news" id="berita">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5" data-aos="fade-up">
            <div>
                <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-primary fw-bold small mb-2">
                    <i class="bi bi-newspaper"></i> KABAR KAMPUS
                </span>
                <h2 class="fw-bold text-dark mt-2 mb-0" style="font-size:2.2rem; letter-spacing:-0.02em;">Berita & Pengumuman</h2>
            </div>
            <div class="news-filter-tabs" id="newsFilterTabs">
                <button type="button" class="nft-btn active" data-filter="semua">Semua</button>
                <button type="button" class="nft-btn" data-filter="Pengumuman">Pengumuman</button>
                <button type="button" class="nft-btn" data-filter="Kegiatan">Kegiatan</button>
                <button type="button" class="nft-btn" data-filter="Prestasi">Prestasi</button>
            </div>
        </div>

        <div class="row g-4" id="newsGrid" data-aos="fade-up" data-aos-delay="100">
            @forelse($news as $item)
                <div class="col-lg-4 col-md-6 news-card-wrapper" data-category="{{ $item->category }}">
                    <div class="news-clean-card h-100 d-flex flex-column">
                        @if($item->image)
                            <div class="ncc-visual" style="background-image: url('{{ asset('storage/'.$item->image) }}');">
                                <span class="ncc-category">{{ $item->category ?? 'INFORMASI' }}</span>
                            </div>
                        @else
                            <div class="ncc-visual ncc-visual--placeholder">
                                <div class="ncc-visual-bg-pattern">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                                <span class="ncc-category">{{ $item->category ?? 'INFORMASI' }}</span>
                            </div>
                        @endif
                        <div class="ncc-body d-flex flex-column flex-grow-1">
                            <div class="ncc-date">
                                <i class="bi bi-calendar3 me-1"></i> {{ optional($item->published_at)->format('d M Y') ?? '-' }}
                            </div>
                            <h5 class="ncc-title">{{ $item->title }}</h5>
                            <p class="ncc-excerpt flex-grow-1">{{ Str::limit(strip_tags($item->excerpt ?? $item->content), 95) }}</p>
                            <span class="ncc-link mt-auto">
                                Baca Pengumuman <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada pengumuman terbaru yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
        <div id="noNewsResult" class="text-center py-5 d-none">
            <p class="text-muted">Tidak ada berita dalam kategori ini.</p>
        </div>
    </div>
</section>
