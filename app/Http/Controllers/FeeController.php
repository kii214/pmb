<?php

namespace App\Http\Controllers;

use App\Models\ContactSetting;
use App\Models\Fee;
use App\Models\ProgramStudy;
use App\Models\RegistrationPath;
use App\Models\RegistrationWave;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $programs = ProgramStudy::active()->get();
        $paths = RegistrationPath::active()->get();
        $waves = RegistrationWave::active()->get();
        $setting = ContactSetting::first();

        $selectedProgram = $request->query('program_id')
            ? ProgramStudy::find($request->query('program_id'))
            : $programs->first();

        $selectedPath = $request->query('path_id')
            ? RegistrationPath::find($request->query('path_id'))
            : $paths->first();

        $selectedWave = $request->query('wave_id')
            ? RegistrationWave::find($request->query('wave_id'))
            : $waves->first();

        $fees = Fee::query()
            ->when($selectedProgram, fn ($query) => $query->where('program_study_id', $selectedProgram->id))
            ->when($selectedPath, fn ($query) => $query->where('registration_path_id', $selectedPath->id))
            ->when($selectedWave, fn ($query) => $query->where('registration_wave_id', $selectedWave->id))
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        return view('fees.index', [
            'programs' => $programs,
            'paths' => $paths,
            'waves' => $waves,
            'selectedProgram' => $selectedProgram,
            'selectedPath' => $selectedPath,
            'selectedWave' => $selectedWave,
            'fees' => $fees,
            'total' => $fees->sum('amount'),
            'setting' => $setting,
        ]);
    }
}
