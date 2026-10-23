{{-- ===================== FINAL CALL TO ACTION ===================== --}}
@php
    $waSetting = $setting ?? \App\Models\ContactSetting::first();
    $waNum = preg_replace('/[^0-9]/', '', $waSetting?->whatsapp_number ?? '6281234567890');
    $waText = urlencode($waSetting?->whatsapp_message ?? 'Halo Admin PMB STMIK ROSMA, saya ingin bertanya seputar pendaftaran mahasiswa baru.');
@endphp
<section class="section-cta" id="daftar">
    <div class="container text-center">
        <div class="mx-auto" style="max-width: 680px;" data-aos="fade-up">
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold small mb-3">
                PENERIMAAN MAHASISWA BARU {{ now()->year }}/{{ now()->year+1 }}
            </span>
            <h2 class="display-6 fw-bold text-white mb-3" style="line-height:1.25;">
                Siap Melangkah Menjadi Profesional Teknologi?
            </h2>
            <p class="text-white-50 lead fs-6 mb-4" style="line-height:1.7;">
                Jangan tunda kesempatan emas ini. Kuota pendaftaran dan beasiswa terbatas untuk setiap gelombang. Daftarkan diri Anda sekarang juga.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('applications.create') }}" class="cta-btn-primary shadow">
                    <i class="bi bi-pencil-square me-1"></i> Daftar Online Sekarang
                </a>
                <a href="https://wa.me/{{ $waNum }}?text={{ $waText }}" target="_blank" class="cta-btn-whatsapp shadow">
                    <i class="bi bi-whatsapp me-1"></i> Konsultasi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
