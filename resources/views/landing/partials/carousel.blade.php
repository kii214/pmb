{{-- ===================== HERO CAROUSEL BANNER (PALING ATAS) ===================== --}}
<div id="heroBannerCarousel" class="carousel slide hero-carousel-wrapper" data-bs-ride="carousel" data-bs-interval="6000">
    @php
        $defaultSlides = [
            [
                'badge' => 'PMB ' . now()->year . '/' . (now()->year+1) . ' RESMI DIBUKA',
                'title' => 'Raih Karir Digital Bersama <span class="hero-highlight">STMIK ROSMA</span>',
                'desc'  => 'Pusat pendidikan tinggi teknologi informasi terpercaya di Karawang. Terakreditasi LAM-INFOKOM dengan kurikulum terapan siap kerja dan jejaring 50+ mitra industri.',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1920&q=80',
                'theme' => 'navy',
                'btn1_text' => 'Daftar Sekarang',
                'btn1_link' => route('applications.create'),
                'btn2_text' => 'Jalur Pendaftaran',
                'btn2_link' => '#jalur',
            ],
            [
                'badge' => 'PROGRAM BEASISWA KULIAH',
                'title' => 'Wujudkan Mimpimu dengan <span class="hero-highlight">Beasiswa KIP & YAPEROS</span>',
                'desc'  => 'Jangan biarkan biaya jadi penghalang. Tersedia beasiswa penuh KIP Kuliah dari pemerintah dan beasiswa prestasi Yayasan Pendidikan Rosma.',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1920&q=80',
                'theme' => 'orange',
                'btn1_text' => 'Lihat Beasiswa & Jalur',
                'btn1_link' => '#jalur',
                'btn2_text' => 'Daftar Sekarang',
                'btn2_link' => route('applications.create'),
            ],
            [
                'badge' => 'KELAS KARYAWAN & HYBRID',
                'title' => 'Kuliah Fleksibel untuk <span class="hero-highlight">Pekerja Profesional</span>',
                'desc'  => 'Tingkatkan jenjang karir Anda tanpa mengganggu waktu kerja. Kuliah kelas malam & Sabtu dengan dukungan portal E-Learning mandiri 24 jam.',
                'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1920&q=80',
                'theme' => 'green',
                'btn1_text' => 'Daftar Kelas Karyawan',
                'btn1_link' => route('applications.create'),
                'btn2_text' => 'Rincian Biaya Kuliah',
                'btn2_link' => route('fees.index'),
            ],
        ];

        $hasDbBanners = isset($banners) && $banners->count() > 0;
        $totalSlides = $hasDbBanners ? $banners->count() : count($defaultSlides);
    @endphp

    {{-- Carousel Indicators --}}
    <div class="carousel-indicators">
        @for($i = 0; $i < $totalSlides; $i++)
            <button type="button" data-bs-target="#heroBannerCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-label="Slide {{ $i + 1 }}"></button>
        @endfor
    </div>

    {{-- Carousel Inner Slides --}}
    <div class="carousel-inner">
        @if($hasDbBanners)
            @foreach($banners as $index => $banner)
                @php
                    $bgImg = $banner->image ? asset('storage/' . $banner->image) : $defaultSlides[$index % count($defaultSlides)]['image'];
                    $badge = $banner->badge_text ?: ('PMB ' . now()->year . '/' . (now()->year+1) . ' RESMI DIBUKA');
                    $btnText = $banner->button_text ?: 'Daftar Sekarang';
                    $btnLink = $banner->button_link ?: route('applications.create');
                @endphp
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="hero-carousel-slide" style="background-image: url('{{ $bgImg }}');">
                        <div class="hero-carousel-overlay"></div>
                        <div class="container hero-carousel-content">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-xl-8">
                                    <div class="hero-carousel-badge mb-3">
                                        <span class="badge-pulse-dot me-2"></span>
                                        <span>{{ $badge }}</span>
                                    </div>
                                    <h1 class="hero-carousel-title">
                                        {!! str_replace('STMIK ROSMA', '<span class="hero-highlight">STMIK ROSMA</span>', e($banner->title)) !!}
                                    </h1>
                                    @if($banner->description)
                                        <p class="hero-carousel-desc">{{ $banner->description }}</p>
                                    @endif
                                    <div class="d-flex gap-3 flex-wrap align-items-center pt-2">
                                        <a href="{{ $btnLink }}" class="btn-hero-carousel-primary">
                                            <i class="bi bi-pencil-square me-2"></i>{{ $btnText }}
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                        <a href="#jalur" class="btn-hero-carousel-ghost">
                                            <i class="bi bi-signpost-2 me-2"></i>Jalur Pendaftaran
                                        </a>
                                        <a href="{{ route('fees.index') }}" class="btn-hero-carousel-ghost">
                                            <i class="bi bi-wallet2 me-2"></i>Biaya Kuliah
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @foreach($defaultSlides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="hero-carousel-slide" style="background-image: url('{{ $slide['image'] }}');">
                        <div class="hero-carousel-overlay"></div>
                        <div class="container hero-carousel-content">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-xl-8">
                                    <div class="hero-carousel-badge mb-3">
                                        <span class="badge-pulse-dot me-2"></span>
                                        <span>{{ $slide['badge'] }}</span>
                                    </div>
                                    <h1 class="hero-carousel-title">
                                        {!! $slide['title'] !!}
                                    </h1>
                                    <p class="hero-carousel-desc">{{ $slide['desc'] }}</p>
                                    <div class="d-flex gap-3 flex-wrap align-items-center pt-2">
                                        <a href="{{ $slide['btn1_link'] }}" class="btn-hero-carousel-primary">
                                            <i class="bi bi-pencil-square me-2"></i>{{ $slide['btn1_text'] }}
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                        <a href="{{ $slide['btn2_link'] }}" class="btn-hero-carousel-ghost">
                                            <i class="bi bi-info-circle me-2"></i>{{ $slide['btn2_text'] }}
                                        </a>
                                        <a href="{{ route('fees.index') }}" class="btn-hero-carousel-ghost">
                                            <i class="bi bi-wallet2 me-2"></i>Biaya Kuliah
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Controls (Panah Kiri & Kanan) --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#heroBannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroBannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Selanjutnya</span>
    </button>
</div>
