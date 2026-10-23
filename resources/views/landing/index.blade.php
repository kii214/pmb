@extends('layouts.public')

@section('title', 'PMB STMIK ROSMA - Penerimaan Mahasiswa Baru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ time() }}">
    <style>
    /* ── Campus Stats Panel (Vue) ── */
    .csv-panel{background:#fff;border:1px solid #d1d5db;border-radius:14px;overflow:hidden;box-shadow:0 6px 30px rgba(0,0,0,.08);}
    .csv-header{display:flex;align-items:center;gap:8px;padding:11px 18px;background:#f3f4f6;border-bottom:1px solid #e5e7eb;}
    .csv-dots{display:flex;gap:6px;}
    .csv-dot{width:11px;height:11px;border-radius:50%;display:inline-block;}
    .csv-dot-r{background:#ef4444;}.csv-dot-y{background:#eab308;}.csv-dot-g{background:#22c55e;}
    .csv-header-title{font-size:.77rem;font-weight:600;color:#6b7280;margin-left:4px;}
    .csv-body{padding:17px 20px 15px;}
    .csv-orbs-area{position:relative;height:108px;background:linear-gradient(135deg,#f0f4ff 0%,#f8fafc 100%);border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:15px;}
    .csv-orb{position:absolute;animation:csvFloat 3.5s ease-in-out infinite;filter:drop-shadow(0 2px 5px rgba(0,0,0,.12));line-height:1;}
    .csv-orbs-label{position:absolute;bottom:8px;left:0;right:0;text-align:center;font-size:.62rem;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:1px;}
    @keyframes csvFloat{0%,100%{transform:translateY(0) rotate(0deg);}33%{transform:translateY(-8px) rotate(3deg);}66%{transform:translateY(-4px) rotate(-2deg);}}
    .csv-tabs{display:flex;gap:5px;margin-bottom:13px;background:#f3f4f6;padding:4px;border-radius:8px;}
    .csv-tab{flex:1;border:none;background:transparent;padding:7px 10px;border-radius:6px;font-size:.79rem;font-weight:600;color:#6b7280;cursor:pointer;transition:all .2s ease;}
    .csv-tab--active{background:#fff;color:#1a4480;box-shadow:0 1px 4px rgba(0,0,0,.08);}
    .csv-stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:11px;margin-bottom:13px;}
    .csv-feature-card{background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:14px 12px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:7px;transition:all .25s ease;}
    .csv-feature-card:hover{background:#fff;border-color:#1a4480;box-shadow:0 6px 18px rgba(26,68,128,.1);transform:translateY(-2px);}
    .csv-icon-bubble{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.35rem;margin-bottom:2px;transition:transform .25s ease;}
    .csv-feature-card:hover .csv-icon-bubble{transform:scale(1.1);}
    .csv-feature-title{font-size:.83rem;font-weight:700;color:#111827;line-height:1.25;}
    .csv-feature-desc{font-size:.71rem;color:#6b7280;line-height:1.3;}
    .csv-accr-list{margin-bottom:13px;}
    .csv-accr-header{font-size:.73rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px;margin-bottom:11px;display:flex;align-items:center;gap:6px;}
    .csv-accr-row{display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid #f3f4f6;}
    .csv-accr-row:last-child{border-bottom:none;}
    .csv-accr-badge{font-size:.66rem;font-weight:700;padding:3px 10px;border-radius:50px;white-space:nowrap;flex-shrink:0;text-transform:uppercase;letter-spacing:.3px;}
    .csv-accr-badge--baiksekali{background:#dcfce7;color:#166534;border:1px solid #86efac;}
    .csv-accr-badge--baik{background:#dbeafe;color:#1e40af;border:1px solid #93c5fd;}
    .csv-accr-info{display:flex;flex-direction:column;}
    .csv-accr-info strong{font-size:.8rem;color:#111827;font-weight:600;line-height:1.2;}
    .csv-accr-info span{font-size:.71rem;color:#6b7280;margin-top:1px;}
    .csv-footer{display:flex;align-items:center;gap:7px;padding-top:10px;border-top:1px solid #e5e7eb;font-size:.73rem;color:#6b7280;}
    .csv-live-dot{width:7px;height:7px;background:#22c55e;border-radius:50%;flex-shrink:0;animation:csvPulse 2s infinite;}
    @keyframes csvPulse{0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,.5);}50%{box-shadow:0 0 0 5px rgba(34,197,94,0);}}
    .csv-fade-enter-active,.csv-fade-leave-active{transition:opacity .2s ease,transform .2s ease;}
    .csv-fade-enter-from{opacity:0;transform:translateY(4px);}
    .csv-fade-leave-to{opacity:0;transform:translateY(-4px);}

    @media (max-width: 575.98px) {
        .csv-body { padding: 12px 14px 12px; }
        .csv-orbs-area { height: 86px; margin-bottom: 11px; }
        .csv-stats-grid { gap: 8px; margin-bottom: 10px; }
        .csv-feature-card { padding: 10px 8px; border-radius: 10px; gap: 4px; }
        .csv-icon-bubble { width: 38px; height: 38px; border-radius: 8px; font-size: 1.15rem; }
        .csv-feature-title { font-size: 0.76rem; }
        .csv-feature-desc { font-size: 0.65rem; }
        .csv-tab { padding: 6px 8px; font-size: 0.74rem; }
        .csv-accr-row { gap: 8px; padding: 6px 0; }
        .csv-accr-badge { font-size: 0.6rem; padding: 2px 7px; }
        .csv-accr-info strong { font-size: 0.74rem; }
        .csv-accr-info span { font-size: 0.66rem; }
        .csv-footer { font-size: 0.68rem; }
    }
    </style>
@endpush

@section('content')
    {{-- 1. Hero Banner Carousel di Paling Atas --}}
    @include('landing.partials.carousel')

    {{-- 2. Profil Institusi & Foto Mahasiswa Almet (Bisa diatur di Admin) --}}
    @include('landing.partials.hero')

    {{-- 3. Pilar Layanan & Mitra Industri --}}
    @include('landing.partials.features')

    {{-- 4. Jalur Pendaftaran Mahasiswa Baru & Program Beasiswa --}}
    @include('landing.partials.paths')

    {{-- 5. Program Studi Unggulan (LAM-INFOKOM) --}}
    @include('landing.partials.programs')

    {{-- 7. Alur Pendaftaran Online --}}
    @include('landing.partials.steps')

    {{-- 8. Berita & Pengumuman Kampus --}}
    @include('landing.partials.news')

    {{-- 9. Biaya Pendidikan & Simulasi --}}
    @include('landing.partials.fees')

    {{-- 10. Tanya Jawab (FAQ) --}}
    @include('landing.partials.faq')

    {{-- 11. Call To Action & Konsultasi WhatsApp --}}
    @include('landing.partials.cta')
@endsection

@push('scripts')
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="{{ asset('js/campus-stats.js') }}?v={{ time() }}"></script>
<script>
    // Tab Alur Pendaftaran
    function switchAlurTab(button, targetId) {
        document.querySelectorAll('#alurSelector .asc-btn').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        document.querySelectorAll('.alur-content-box').forEach(box => {
            box.classList.remove('active', 'd-block');
            box.classList.add('d-none');
        });
        const target = document.getElementById(targetId);
        if (target) { target.classList.remove('d-none'); target.classList.add('active', 'd-block'); }
    }
    // Filter Berita & Pengumuman
    document.querySelectorAll('.nft-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.nft-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            let matchCount = 0;
            document.querySelectorAll('.news-card-wrapper').forEach(card => {
                const isMatch = (filter === 'semua' || card.dataset.category === filter);
                card.style.display = isMatch ? '' : 'none';
                if (isMatch) matchCount++;
            });
            const noResultEl = document.getElementById('noNewsResult');
            if (noResultEl) noResultEl.classList.toggle('d-none', matchCount > 0);
        });
    });
</script>
@endpush
