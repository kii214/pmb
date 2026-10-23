<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\ContactSetting;
use App\Models\Faq;
use App\Models\Fee;
use App\Models\News;
use App\Models\ProgramStudy;
use App\Models\RegistrationPath;
use App\Models\RegistrationStep;
use App\Models\RegistrationWave;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil prodi pertama / Informatika
        $defaultProgram = ProgramStudy::where('name', 'like', '%Informatika%')->first() ?? ProgramStudy::active()->first();
        // Ambil jalur reguler
        $regulerPath = RegistrationPath::where('name', 'like', '%Reguler%')->first() ?? RegistrationPath::active()->first();
        // Ambil gelombang yang ditetapkan admin (is_current=true), fallback ke aktif pertama
        $currentWave = RegistrationWave::current()->first();
        $activeWave  = $currentWave ?? RegistrationWave::where('status', 'active')->orderBy('sort_order')->first() ?? RegistrationWave::first();

        // Ambil biaya untuk simulasi di landing page
        $simulationFees = collect();
        if ($defaultProgram && $regulerPath && $activeWave) {
            $simulationFees = Fee::where('program_study_id', $defaultProgram->id)
                ->where('registration_path_id', $regulerPath->id)
                ->where('registration_wave_id', $activeWave->id)
                ->where('status', 'active')
                ->orderBy('sort_order')
                ->get();
        }

        return view('landing.index', [
            'banners'        => Banner::active()->get(),
            'setting'        => ContactSetting::first(),
            'programs'       => ProgramStudy::active()->get(),
            'paths'          => RegistrationPath::active()->get(),
            'steps'          => RegistrationStep::active()->get(),
            'waves'          => RegistrationWave::active()->get(),
            'news'           => News::published()->take(6)->get(),
            'bannerNews'     => News::published()->featured()->take(3)->get(),
            'faqs'           => Faq::active()->get(),
            'partners'       => \App\Models\Partner::where('is_active', true)->orderBy('order')->get(),
            'simulationFees' => $simulationFees,
            'defaultProgram' => $defaultProgram,
            'activeWave'     => $activeWave,
            'currentWave'    => $currentWave,
        ]);
    }
}
