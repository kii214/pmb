<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $application = Application::with(['programStudy', 'registrationWave'])->where('user_id', $user->id)->first();
        $setting = \App\Models\ContactSetting::first();
        
        $fee = null;
        if ($application && $application->program_study_id && $application->registration_wave_id) {
            $fee = \App\Models\Fee::where('program_study_id', $application->program_study_id)
                ->where('registration_wave_id', $application->registration_wave_id)
                ->first();
        }

        return view('dashboard.index', [
            'user' => $user,
            'application' => $application,
            'progress' => $application ? $application->progress : 30,
            'setting' => $setting,
            'fee' => $fee,
        ]);
    }
}
