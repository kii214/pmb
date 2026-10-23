{{-- ===================== FAQ / PUSAT BANTUAN ===================== --}}
<section class="section-faq" id="faq">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-primary fw-bold small mb-2">
                        <i class="bi bi-question-circle"></i> TANYA JAWAB
                    </span>
                    <h2 class="fw-bold text-dark mt-2 mb-0" style="font-size:2.2rem; letter-spacing:-0.02em;">Pertanyaan yang Sering Diajukan</h2>
                    <p class="text-muted mt-2">Jawaban cepat atas pertanyaan paling mendasar mengenai PMB STMIK ROSMA.</p>
                </div>
                
                <div class="accordion accordion-flush" id="faqAccordion" data-aos="fade-up" data-aos-delay="100">
                    @forelse($faqs as $faq)
                        <div class="accordion-item faq-item border mb-3 bg-white rounded-4 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button faq-btn rounded-4 {{ $loop->first ? '' : 'collapsed' }} shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="faq-{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body faq-body">{{ $faq->answer }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="accordion-item faq-item border mb-3 bg-white rounded-4 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button faq-btn rounded-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq-def1">
                                    Apakah STMIK ROSMA menerima mahasiswa yang sudah bekerja?
                                </button>
                            </h2>
                            <div id="faq-def1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body faq-body">
                                    Ya, STMIK ROSMA menyediakan Kelas Karyawan / Ekstensi dengan jadwal perkuliahan malam dan hari Sabtu serta sistem Hybrid (online & offline) yang sangat cocok untuk pekerja di kawasan industri.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item border mb-3 bg-white rounded-4 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button faq-btn rounded-4 collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq-def2">
                                    Bagaimana cara mendaftar beasiswa KIP Kuliah di STMIK ROSMA?
                                </button>
                            </h2>
                            <div id="faq-def2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body faq-body">
                                    Calon mahasiswa terlebih dahulu mendaftar pada portal resmi KIP Kuliah Kemdikbud dan memilih STMIK ROSMA sebagai perguruan tinggi tujuan, kemudian mengisi formulir PMB di pmb.rosma.ac.id dengan memilih opsi Beasiswa KIP Kuliah.
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
