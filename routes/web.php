<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramStudyController;
use App\Models\Application;
use App\Models\Banner;
use App\Models\ContactSetting;
use App\Models\Faq;
use App\Models\Fee as FeeModel;
use App\Models\News;
use App\Models\ProgramStudy;
use App\Models\RegistrationPath;
use App\Models\RegistrationStep;
use App\Models\RegistrationWave;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/program-studi', [ProgramStudyController::class, 'index'])->name('programs.index');
Route::get('/program-studi/{slug}', [ProgramStudyController::class, 'show'])->name('programs.show');
Route::get('/biaya-kuliah', [FeeController::class, 'index'])->name('fees.index');

Route::get('/pendaftaran', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/pendaftaran', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/cek-status', [ApplicationController::class, 'status'])->name('applications.status');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Alur Pendaftaran CAMABA
    Route::post('/dashboard/upload-payment', function(Request $request) {
        $request->validate(['payment_proof' => 'required|image|max:2048']);
        $application = Application::where('user_id', Auth::id())->firstOrFail();
        
        $path = $request->file('payment_proof')->store('payments', 'public');
        
        $application->update([
            'payment_proof' => $path,
            'payment_status' => 'uploaded',
            'status' => 'submitted',
            'progress' => 100
        ]);
        
        // Kirim notifikasi email konfirmasi bahwa berkas & bukti bayar sudah masuk ke admin
        try {
            $user = $application->user;
            if ($user && $user->email) {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ApplicationSubmittedMail($application));
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim email notifikasi pembayaran: ' . $e->getMessage());
        }
        
        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Pendaftaran Anda sedang menunggu verifikasi oleh Admin PMB.');
    })->name('applications.payment.upload');

    Route::post('/dashboard/submit', function(Request $request) {
        $application = Application::where('user_id', Auth::id())->firstOrFail();
        if ($application->payment_status !== 'uploaded') {
            return back()->with('error', 'Anda harus mengunggah bukti pembayaran terlebih dahulu.');
        }
        
        $application->update([
            'status' => 'submitted',
            'progress' => 100
        ]);
        
        return back()->with('success', 'Pendaftaran Anda berhasil dikirim ke Admin untuk diverifikasi!');
    })->name('applications.submit');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        $applicationCount = Application::count();
        
        // Data untuk grafik status pendaftar
        $statusStats = Application::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        // Data untuk grafik pendaftar per program studi
        $programStats = Application::selectRaw('program_study_id, count(*) as count')
            ->groupBy('program_study_id')
            ->with('programStudy')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->programStudy ? $item->programStudy->name : 'Lainnya',
                    'count' => $item->count
                ];
            });

        return view('admin.dashboard', [
            'programCount'     => ProgramStudy::count(),
            'applicationCount' => $applicationCount,
            'pendingCount'     => Application::where('status', 'submitted')->count(),
            'acceptedCount'    => Application::where('status', 'accepted')->count(),
            'statusStats'      => $statusStats,
            'programStats'     => $programStats,
        ]);
    })->name('admin.dashboard');

    Route::get('/program-studi', function () {
        return view('admin.programs', ['programs' => ProgramStudy::orderBy('sort_order')->get()]);
    })->name('admin.programs');

    Route::post('/program-studi', function (Request $request) {
        $validated = $request->validate([
            'name'                          => 'required|string|max:255',
            'level'                         => 'required|string|max:50',
            'code'                          => 'required|string|max:50',
            'accreditation'                 => 'required|string|max:100',
            'accreditation_sk_number'       => 'nullable|string|max:255',
            'accreditation_year'            => 'nullable|integer|min:2000|max:2100',
            'accreditation_valid_from'      => 'nullable|date',
            'accreditation_valid_until'     => 'nullable|date',
            'accreditation_certificate_url' => 'nullable|string|max:500',
            'description'                   => 'required|string',
        ]);

        ProgramStudy::create(array_merge($validated, [
            'slug'       => Str::slug($validated['name']),
            'status'     => 'active',
            'sort_order' => ProgramStudy::count() + 1,
        ]));

        return redirect()->route('admin.programs')->with('success', 'Program studi berhasil ditambahkan.');
    })->name('admin.programs.store');

    Route::post('/program-studi/{program}/update', function (Request $request, ProgramStudy $program) {
        $validated = $request->validate([
            'name'                          => 'required|string|max:255',
            'code'                          => 'required|string|max:50',
            'level'                         => 'required|string|max:50',
            'description'                   => 'required|string',
            'status'                        => 'required|in:active,inactive',
            'accreditation'                 => 'required|string|max:100',
            'accreditation_sk_number'       => 'nullable|string|max:255',
            'accreditation_year'            => 'nullable|integer|min:2000|max:2100',
            'accreditation_valid_from'      => 'nullable|date',
            'accreditation_valid_until'     => 'nullable|date',
            'accreditation_certificate_url' => 'nullable|string|max:500',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $program->update($validated);
        return redirect()->route('admin.programs')->with('success', 'Data program studi ' . $program->name . ' berhasil diperbarui.');
    })->name('admin.programs.update');

    Route::post('/program-studi/{program}/delete', function (ProgramStudy $program) {
        if ($program->applications()->count() > 0) {
            return back()->with('error', 'Program studi tidak dapat dihapus karena sudah memiliki pendaftar. Anda dapat mengubah statusnya menjadi non-aktif.');
        }
        $program->fees()->delete();
        $program->delete();
        return back()->with('success', 'Program studi berhasil dihapus.');
    })->name('admin.programs.destroy');

    // BIAYA - Index: tampil daftar gelombang
    Route::get('/biaya-kuliah', function () {
        return view('admin.fees', [
            'waves'    => RegistrationWave::withCount('fees')->orderBy('sort_order')->get(),
            'vouchers' => Voucher::orderByDesc('id')->get(),
        ]);
    })->name('admin.fees');

    // BIAYA - Detail gelombang: tampil daftar jurusan
    Route::get('/biaya-kuliah/{wave}', function (RegistrationWave $wave) {
        $programs = ProgramStudy::withCount(['fees as fee_count' => function($q) use ($wave) {
            $q->where('registration_wave_id', $wave->id);
        }])->orderBy('sort_order')->get();
        return view('admin.fees.detail', [
            'wave'     => $wave,
            'programs' => $programs,
        ]);
    })->name('admin.fees.show');

    // BIAYA - Detail jurusan dalam gelombang: tampil & isi komponen biaya
    Route::get('/biaya-kuliah/{wave}/{program}', function (RegistrationWave $wave, ProgramStudy $program) {
        $fees = FeeModel::with('path')
            ->where('registration_wave_id', $wave->id)
            ->where('program_study_id', $program->id)
            ->orderBy('sort_order')->get();
        $paths = RegistrationPath::orderBy('sort_order')->get();
        return view('admin.fees.program', compact('wave', 'program', 'fees', 'paths'));
    })->name('admin.fees.program');

    // WAVE CRUD
    Route::post('/gelombang', function (Request $request) {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'academic_year' => 'required|string|max:20',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
        ]);
        RegistrationWave::create(array_merge($validated, [
            'status'     => 'active',
            'sort_order' => RegistrationWave::count() + 1,
        ]));
        return redirect()->route('admin.fees')->with('success', 'Gelombang berhasil ditambahkan.');
    })->name('admin.waves.store');

    Route::post('/gelombang/{wave}/update', function (Request $request, RegistrationWave $wave) {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'academic_year' => 'required|string|max:20',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'status'        => 'required|in:active,inactive',
        ]);
        $wave->update($validated);
        return back()->with('success', 'Gelombang berhasil diperbarui.');
    })->name('admin.waves.update');

    Route::post('/gelombang/{wave}/delete', function (RegistrationWave $wave) {
        $wave->delete();
        return redirect()->route('admin.fees')->with('success', 'Gelombang berhasil dihapus.');
    })->name('admin.waves.destroy');

    Route::post('/gelombang/{wave}/set-current', function (RegistrationWave $wave) {
        $wave->setCurrent();
        return back()->with('success', "Gelombang \"{$wave->name}\" berhasil ditetapkan sebagai gelombang aktif saat ini.");
    })->name('admin.waves.setCurrent');

    // FEE STORE
    Route::post('/biaya-kuliah', function (Request $request) {
        $validated = $request->validate([
            'program_study_id'     => 'required|exists:program_studies,id',
            'registration_path_id' => 'required|exists:registration_paths,id',
            'registration_wave_id' => 'required|exists:registration_waves,id',
            'name'                 => 'required|string|max:255',
            'amount'               => 'required|integer|min:0',
        ]);

        FeeModel::create([
            'program_study_id'     => $validated['program_study_id'],
            'registration_path_id' => $validated['registration_path_id'],
            'registration_wave_id' => $validated['registration_wave_id'],
            'name'                 => $validated['name'],
            'amount'               => $validated['amount'],
            'status'               => 'active',
            'sort_order'           => FeeModel::count() + 1,
        ]);

        return redirect()->route('admin.fees.program', [$validated['registration_wave_id'], $validated['program_study_id']])->with('success', 'Biaya berhasil ditambahkan.');
    })->name('admin.fees.store');

    // FEE UPDATE
    Route::post('/biaya-kuliah/{fee}/update', function (Request $request, FeeModel $fee) {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'amount'               => 'required|integer|min:0',
            'registration_path_id' => 'required|exists:registration_paths,id',
        ]);
        $fee->update($validated);
        return redirect()->route('admin.fees.program', [$fee->registration_wave_id, $fee->program_study_id])->with('success', 'Biaya berhasil diperbarui.');
    })->name('admin.fees.update');

    // FEE DESTROY
    Route::post('/biaya-kuliah/{fee}/delete', function (FeeModel $fee) {
        $waveId    = $fee->registration_wave_id;
        $programId = $fee->program_study_id;
        $fee->delete();
        return redirect()->route('admin.fees.program', [$waveId, $programId])->with('success', 'Biaya berhasil dihapus.');
    })->name('admin.fees.destroy');


    // VOUCHERS CRUD
    Route::post('/vouchers', function (Request $request) {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:50',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percent',
            'target_fee' => 'required|in:all,registration,ukt',
            'valid_until' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        Voucher::create($validated);
        return redirect()->route('admin.fees')->with('success', 'Voucher berhasil ditambahkan.');
    })->name('admin.vouchers.store');

    Route::post('/vouchers/{voucher}/update', function (Request $request, Voucher $voucher) {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percent',
            'target_fee' => 'required|in:all,registration,ukt',
            'valid_until' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        $voucher->update($validated);
        return back()->with('success', 'Voucher berhasil diperbarui.');
    })->name('admin.vouchers.update');

    Route::post('/vouchers/{voucher}/delete', function (Voucher $voucher) {
        $voucher->delete();
        return back()->with('success', 'Voucher berhasil dihapus.');
    })->name('admin.vouchers.destroy');

    Route::get('/tahapan', function () {
        return view('admin.steps', ['steps' => RegistrationStep::orderBy('sort_order')->get()]);
    })->name('admin.steps');

    Route::post('/tahapan', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
            'status' => 'nullable|in:active,inactive',
        ]);

        RegistrationStep::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $request->input('status', 'active'),
            'sort_order' => RegistrationStep::count() + 1,
            'icon' => $validated['icon'],
            'color' => '#0B1F3A',
        ]);

        return redirect()->route('admin.steps')->with('success', 'Tahapan berhasil ditambahkan.');
    })->name('admin.steps.store');

    Route::post('/tahapan/{step}/update', function (Request $request, RegistrationStep $step) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        $step->update($validated);
        return redirect()->route('admin.steps')->with('success', 'Tahapan berhasil diperbarui.');
    })->name('admin.steps.update');

    Route::post('/tahapan/{step}/delete', function (RegistrationStep $step) {
        $step->delete();
        return redirect()->route('admin.steps')->with('success', 'Tahapan berhasil dihapus.');
    })->name('admin.steps.destroy');

    Route::get('/pengaturan', function () {
        return view('admin.settings', ['setting' => ContactSetting::first()]);
    })->name('admin.settings');

    Route::post('/pengaturan', function (Request $request) {
        $validated = $request->validate([
            'admin_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:30',
            'whatsapp_message' => 'required|string',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
        ]);

        ContactSetting::updateOrCreate(
            ['id' => 1],
            $validated + ['status' => 'active']
        );

        return redirect()->route('admin.settings')->with('success', 'Pengaturan sistem & kontak berhasil disimpan.');
    })->name('admin.settings.store');

    Route::get('/berita', function () {
        return view('admin.news', ['news' => News::orderByDesc('published_at')->get()]);
    })->name('admin.news');

    Route::post('/berita', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        } else {
            // Default image yang menarik kaya corak/pola jika tidak ada gambar (menggunakan placeholder dinamis)
            $slug = Str::slug($validated['title']);
            $imagePath = "https://picsum.photos/seed/{$slug}/800/500?blur=1";
        }

        News::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'image' => $imagePath,
            'category' => $validated['category'] ?? 'Umum',
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('admin.news')->with('success', 'Berita berhasil ditambahkan.');
    })->name('admin.news.store');

    Route::post('/berita/{news}/update', function (Request $request, News $news) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'category' => $validated['category'] ?? 'Umum',
        ];

        if ($request->hasFile('image')) {
            if ($news->image && !Str::startsWith($news->image, 'http')) {
                Storage::disk('public')->delete($news->image);
            }
            $updateData['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($updateData);

        return back()->with('success', 'Berita berhasil diperbarui.');
    })->name('admin.news.update');

    Route::post('/berita/{news}/delete', function (News $news) {
        if ($news->image && !Str::startsWith($news->image, 'http')) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return back()->with('success', 'Berita berhasil dihapus.');
    })->name('admin.news.destroy');

    Route::get('/faq', function () {
        return view('admin.faq', ['faqs' => Faq::orderBy('sort_order')->get()]);
    })->name('admin.faq');

    Route::post('/faq', function (Request $request) {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        Faq::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'status' => $request->input('status', 'active'),
            'sort_order' => Faq::count() + 1,
        ]);

        return redirect()->route('admin.faq')->with('success', 'FAQ berhasil ditambahkan.');
    })->name('admin.faq.store');

    Route::post('/faq/{faq}/update', function (Request $request, Faq $faq) {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        $faq->update($validated);
        return redirect()->route('admin.faq')->with('success', 'FAQ berhasil diperbarui.');
    })->name('admin.faq.update');

    Route::post('/faq/{faq}/delete', function (Faq $faq) {
        $faq->delete();
        return redirect()->route('admin.faq')->with('success', 'FAQ berhasil dihapus.');
    })->name('admin.faq.destroy');

    // BANNERS CRUD
    Route::get('/banners', function () {
        return view('admin.banners', ['banners' => Banner::orderBy('sort_order')->get()]);
    })->name('admin.banners.index');

    Route::post('/banners', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:10240',
            'theme_color' => 'required|string|in:navy,green,orange',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $validated['sort_order'] = Banner::count() + 1;
        
        Banner::create($validated);
        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan.');
    })->name('admin.banners.store');

    Route::post('/banners/{banner}/update', function (Request $request, Banner $banner) {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|max:10240',
            'theme_color' => 'required|string|in:navy,green,orange',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'badge_text'  => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) Storage::disk('public')->delete($banner->image);
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($validated);
        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui.');
    })->name('admin.banners.update');

    Route::post('/banners/{banner}/delete', function (Banner $banner) {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus.');
    })->name('admin.banners.destroy');

    // FOTO BERANDA (MAHASISWA ALMET) CRUD
    Route::get('/foto-beranda', function () {
        $setting = ContactSetting::firstOrCreate(['id' => 1]);
        return view('admin.hero-media', compact('setting'));
    })->name('admin.hero_media');

    Route::post('/foto-beranda', function (Request $request) {
        $request->validate([
            'hero_image'   => 'nullable|image|max:5120',
            'hero_caption' => 'nullable|string|max:255',
        ]);

        $setting = ContactSetting::firstOrCreate(['id' => 1]);

        if ($request->hasFile('hero_image')) {
            if ($setting->hero_image) {
                Storage::disk('public')->delete($setting->hero_image);
            }
            $setting->hero_image = $request->file('hero_image')->store('media', 'public');
        }

        if ($request->has('hero_caption')) {
            $setting->hero_caption = $request->input('hero_caption');
        }

        $setting->save();

        return back()->with('success', 'Foto mahasiswa almamater / profil beranda berhasil disimpan.');
    })->name('admin.hero_media.update');

    Route::post('/foto-beranda/reset', function () {
        $setting = ContactSetting::firstOrCreate(['id' => 1]);
        if ($setting->hero_image) {
            Storage::disk('public')->delete($setting->hero_image);
            $setting->hero_image = null;
            $setting->save();
        }
        return back()->with('success', 'Foto berhasil direset ke foto default mahasiswa almamater STMIK ROSMA.');
    })->name('admin.hero_media.reset');


    // PARTNERS CRUD
    Route::get('/partners', function () {
        return view('admin.partners', ['partners' => \App\Models\Partner::orderBy('order')->get()]);
    })->name('admin.partners.index');

    Route::post('/partners', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('partners', 'public');
        }

        $validated['order'] = \App\Models\Partner::count() + 1;
        
        \App\Models\Partner::create($validated);
        return redirect()->route('admin.partners.index')->with('success', 'Mitra berhasil ditambahkan.');
    })->name('admin.partners.store');

    Route::post('/partners/{partner}/update', function (Request $request, \App\Models\Partner $partner) {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'image'     => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
            'order'     => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($partner->image) {
                Storage::disk('public')->delete($partner->image);
            }
            $validated['image'] = $request->file('image')->store('partners', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        $partner->update($validated);
        return redirect()->route('admin.partners.index')->with('success', 'Mitra berhasil diperbarui.');
    })->name('admin.partners.update');

    Route::post('/partners/{partner}/delete', function (\App\Models\Partner $partner) {
        if ($partner->image) {
            Storage::disk('public')->delete($partner->image);
        }
        $partner->delete();
        return back()->with('success', 'Mitra berhasil dihapus.');
    })->name('admin.partners.destroy');

    // ====== KELOLA PENDAFTAR (CAMABA) ======
    Route::get('/pendaftar', function (Request $request) {
        $query = Application::with(['programStudy', 'registrationPath', 'registrationWave', 'user'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('application_number', 'like', "%{$search}%")
                  ->orWhereJsonContains('form_data->full_name', $search)
                  ->orWhereJsonContains('form_data->email', $search);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('prodi')) {
            $query->where('program_study_id', $request->prodi);
        }
        if ($request->filled('jalur')) {
            $query->where('registration_path_id', $request->jalur);
        }

        $applications = $query->paginate(15)->withQueryString();
        $programs = ProgramStudy::orderBy('name')->get();
        $paths = RegistrationPath::orderBy('name')->get();

        $stats = [
            'total'     => Application::count(),
            'submitted' => Application::where('status', 'submitted')->count(),
            'verified'  => Application::where('status', 'verified')->count(),
            'accepted'  => Application::where('status', 'accepted')->count(),
            'rejected'  => Application::where('status', 'rejected')->count(),
        ];

        return view('admin.applicants.index', compact('applications', 'programs', 'paths', 'stats'));
    })->name('admin.applicants.index');

    Route::get('/pendaftar/{application}', function (Application $application) {
        $application->load(['programStudy', 'registrationPath', 'registrationWave', 'user']);
        return view('admin.applicants.show', compact('application'));
    })->name('admin.applicants.show');

    Route::post('/pendaftar/{application}/status', function (Request $request, Application $application) {
        $request->validate(['status' => 'required|in:submitted,verified,accepted,rejected,waitlisted']);
        $application->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);
        return back()->with('success', 'Status pendaftar berhasil diperbarui.');
    })->name('admin.applicants.status');

    Route::post('/pendaftar/{application}/delete', function (Application $application) {
        $application->delete();
        return redirect()->route('admin.applicants.index')->with('success', 'Data pendaftar berhasil dihapus.');
    })->name('admin.applicants.delete');

    // Export to Excel (.xls) with professional styling
    Route::get('/pendaftar/export/csv', function (Request $request) {
        $query = Application::with(['programStudy', 'programStudy2', 'registrationPath', 'user']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('program_study_id')) {
            $query->where('program_study_id', $request->program_study_id);
        }
        if ($request->filled('registration_path_id')) {
            $query->where('registration_path_id', $request->registration_path_id);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('application_number', 'like', "%{$s}%")
                  ->orWhere('form_data', 'like', "%{$s}%");
            });
        }
        
        $applications = $query->latest()->get();
        $total = $applications->count();
        $accepted = $applications->where('status', 'accepted')->count();
        $submitted = $applications->where('status', 'submitted')->count();
        $verified = $applications->where('status', 'verified')->count();
        $rejected = $applications->where('status', 'rejected')->count();

        $filename = 'LAPORAN_PENDAFTAR_PMB_STMIK_ROSMA_' . date('Ymd_His') . '.xls';

        $output = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        $output .= '<head><meta charset="utf-8">';
        $output .= '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Data Pendaftar PMB</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
        $output .= '<style>
            body { font-family: Calibri, Arial, sans-serif; }
            .kop-title { font-size: 16pt; font-weight: bold; color: #1e3a8a; text-align: center; }
            .kop-sub { font-size: 11pt; color: #475569; text-align: center; }
            .kop-date { font-size: 9pt; color: #64748b; text-align: center; font-style: italic; }
            .stat-box { font-size: 10pt; font-weight: bold; text-align: center; padding: 6px; }
            .th-header { background-color: #1e40af; color: #ffffff; font-weight: bold; font-size: 10pt; text-align: center; vertical-align: middle; height: 32px; border: 1px solid #1e3a8a; }
            .td-cell { font-size: 9.5pt; vertical-align: middle; border: 1px solid #cbd5e1; padding: 5px 8px; }
            .td-center { text-align: center; }
            .td-num { mso-number-format:"\@"; text-align: center; }
            .row-even { background-color: #f8fafc; }
            .row-odd { background-color: #ffffff; }
            .status-accepted { background-color: #dcfce7; color: #15803d; font-weight: bold; text-align: center; }
            .status-submitted { background-color: #fef3c7; color: #b45309; font-weight: bold; text-align: center; }
            .status-verified { background-color: #e0f2fe; color: #0369a1; font-weight: bold; text-align: center; }
            .status-rejected { background-color: #fee2e2; color: #b91c1c; font-weight: bold; text-align: center; }
        </style></head><body>';

        $output .= '<table border="0" cellpadding="0" cellspacing="0">';
        // Title block
        $output .= '<tr><td colspan="19" class="kop-title">PANITIA PENERIMAAN MAHASISWA BARU (PMB)</td></tr>';
        $output .= '<tr><td colspan="19" class="kop-title" style="font-size:14pt; color:#c8940a;">STMIK ROSMA KARAWANG</td></tr>';
        $output .= '<tr><td colspan="19" class="kop-sub">Jl. Parahiyangan No. 62, Adiarsa Barat, Kec. Karawang Barat, Karawang - Jawa Barat</td></tr>';
        $output .= '<tr><td colspan="19" class="kop-date">Dokumen Dicetak pada: ' . date('d F Y - H:i:s') . ' WIB</td></tr>';
        $output .= '<tr><td colspan="19" style="height:12px;"></td></tr>';

        // Summary Statistics Card Row
        $output .= '<tr>';
        $output .= '<td colspan="3" class="stat-box" style="background:#dbeafe;color:#1e40af;border:1px solid #93c5fd;">Total Pendaftar: ' . $total . '</td>';
        $output .= '<td colspan="4" class="stat-box" style="background:#fef3c7;color:#92400e;border:1px solid #fcd34d;">Menunggu Review: ' . $submitted . '</td>';
        $output .= '<td colspan="4" class="stat-box" style="background:#e0f2fe;color:#075985;border:1px solid #7dd3fc;">Diverifikasi: ' . $verified . '</td>';
        $output .= '<td colspan="4" class="stat-box" style="background:#dcfce7;color:#166534;border:1px solid #86efac;">Diterima: ' . $accepted . '</td>';
        $output .= '<td colspan="4" class="stat-box" style="background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;">Ditolak: ' . $rejected . '</td>';
        $output .= '</tr>';
        $output .= '<tr><td colspan="19" style="height:14px;"></td></tr>';

        // Table Header
        $output .= '<tr>';
        $output .= '<th class="th-header" style="width:40px;">No</th>';
        $output .= '<th class="th-header" style="width:130px;">No. Pendaftaran</th>';
        $output .= '<th class="th-header" style="width:190px;">Nama Lengkap</th>';
        $output .= '<th class="th-header" style="width:150px;">NIK</th>';
        $output .= '<th class="th-header" style="width:180px;">Email</th>';
        $output .= '<th class="th-header" style="width:130px;">No. WhatsApp</th>';
        $output .= '<th class="th-header" style="width:110px;">L/P</th>';
        $output .= '<th class="th-header" style="width:130px;">Tempat Lahir</th>';
        $output .= '<th class="th-header" style="width:110px;">Tanggal Lahir</th>';
        $output .= '<th class="th-header" style="width:230px;">Alamat Lengkap</th>';
        $output .= '<th class="th-header" style="width:120px;">Kota/Kab</th>';
        $output .= '<th class="th-header" style="width:170px;">Asal Sekolah</th>';
        $output .= '<th class="th-header" style="width:110px;">NISN</th>';
        $output .= '<th class="th-header" style="width:110px;">Jurusan</th>';
        $output .= '<th class="th-header" style="width:90px;">Lulus</th>';
        $output .= '<th class="th-header" style="width:180px;">Prodi Pilihan 1</th>';
        $output .= '<th class="th-header" style="width:180px;">Prodi Pilihan 2</th>';
        $output .= '<th class="th-header" style="width:140px;">Jalur Masuk</th>';
        $output .= '<th class="th-header" style="width:110px;">Status</th>';
        $output .= '<th class="th-header" style="width:130px;">Tgl Daftar</th>';
        $output .= '</tr>';

        // Data Rows
        foreach ($applications as $i => $app) {
            $fd = $app->form_data ?? [];
            $rowClass = ($i % 2 === 0) ? 'row-even' : 'row-odd';
            
            $statusLabel = match($app->status) {
                'accepted'  => 'DITERIMA',
                'rejected'  => 'DITOLAK',
                'verified'  => 'DIVERIFIKASI',
                'submitted' => 'MENUNGGU',
                default     => strtoupper($app->status)
            };
            $statusClass = match($app->status) {
                'accepted'  => 'status-accepted',
                'rejected'  => 'status-rejected',
                'verified'  => 'status-verified',
                'submitted' => 'status-submitted',
                default     => ''
            };

            $gender = ($fd['gender'] ?? '') === 'L' ? 'Laki-laki' : (($fd['gender'] ?? '') === 'P' ? 'Perempuan' : '-');
            $prodi1 = $app->programStudy ? ($app->programStudy->name . ' (' . $app->programStudy->level . ')') : '-';
            $prodi2 = $app->programStudy2 ? ($app->programStudy2->name . ' (' . $app->programStudy2->level . ')') : '-';

            $output .= "<tr class='{$rowClass}'>";
            $output .= "<td class='td-cell td-center'>" . ($i + 1) . "</td>";
            $output .= "<td class='td-cell td-num'><b>" . htmlspecialchars($app->application_number) . "</b></td>";
            $output .= "<td class='td-cell'><b>" . htmlspecialchars($fd['full_name'] ?? ($app->user->name ?? '-')) . "</b></td>";
            $output .= "<td class='td-cell td-num'>" . htmlspecialchars($fd['nik'] ?? '-') . "</td>";
            $output .= "<td class='td-cell'>" . htmlspecialchars($fd['email'] ?? ($app->user->email ?? '-')) . "</td>";
            $output .= "<td class='td-cell td-num'>" . htmlspecialchars($fd['phone'] ?? '-') . "</td>";
            $output .= "<td class='td-cell td-center'>" . $gender . "</td>";
            $output .= "<td class='td-cell'>" . htmlspecialchars($fd['birth_place'] ?? '-') . "</td>";
            $output .= "<td class='td-cell td-center'>" . htmlspecialchars($fd['birth_date'] ?? '-') . "</td>";
            $output .= "<td class='td-cell'>" . htmlspecialchars($fd['address'] ?? '-') . "</td>";
            $output .= "<td class='td-cell'>" . htmlspecialchars($fd['city'] ?? '-') . "</td>";
            $output .= "<td class='td-cell'>" . htmlspecialchars($fd['school_name'] ?? '-') . "</td>";
            $output .= "<td class='td-cell td-num'>" . htmlspecialchars($fd['nisn'] ?? '-') . "</td>";
            $output .= "<td class='td-cell'>" . htmlspecialchars($fd['major'] ?? '-') . "</td>";
            $output .= "<td class='td-cell td-center'>" . htmlspecialchars($fd['graduation_year'] ?? '-') . "</td>";
            $output .= "<td class='td-cell'><b>" . htmlspecialchars($prodi1) . "</b></td>";
            $output .= "<td class='td-cell'>" . htmlspecialchars($prodi2) . "</td>";
            $output .= "<td class='td-cell'>" . htmlspecialchars($app->registrationPath?->name ?? '-') . "</td>";
            $output .= "<td class='td-cell {$statusClass}'>" . $statusLabel . "</td>";
            $output .= "<td class='td-cell td-center'>" . $app->created_at->format('d/m/Y H:i') . "</td>";
            $output .= '</tr>';
        }

        $output .= '</table></body></html>';

        return response($output, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    })->name('admin.applicants.export');
});


require __DIR__.'/auth.php';
