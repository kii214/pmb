<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ProgramStudy;
use App\Models\RegistrationPath;
use App\Models\RegistrationWave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function create()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['captcha_answer' => $num1 + $num2]);

        return view('application.create', [
            'programs' => ProgramStudy::active()->get(),
            'paths' => RegistrationPath::active()->get(),
            'waves' => RegistrationWave::active()->get(),
            'captcha_num1' => $num1,
            'captcha_num2' => $num2,
        ]);
    }

    public function store(Request $request)
    {
        $expectedAnswer = session('captcha_answer');

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string',
            'address' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',

            'school_name' => 'required|string|max:255',
            'nisn' => 'required|string|size:10',
            'major' => 'required|string|max:255',
            'graduation_year' => 'required|integer',

            'registration_path_id' => 'required|exists:registration_paths,id',
            'kip_number' => 'nullable|string',
            'program_study_id' => 'required|exists:program_studies,id',
            'program_study_2_id' => 'nullable|exists:program_studies,id|different:program_study_id',
            'class_type' => 'required|string',

            'info_source' => 'required|string',
            'reference_name' => 'nullable|string',
            'reference_id' => 'nullable|string',

            'father_name' => 'required|string',
            'father_job' => 'required|string',
            'father_income' => 'required|string',
            'mother_name' => 'required|string',
            'mother_job' => 'required|string',
            'mother_income' => 'required|string',
            'parent_phone' => 'required|string',
            
            'statement_agree' => 'accepted',
            'captcha_answer' => 'required|integer|in:' . $expectedAnswer,
        ], [
            'nik.size' => 'NIK harus 16 digit.',
            'nisn.size' => 'NISN harus 10 digit.',
            'captcha_answer.in' => 'Jawaban captcha salah.',
            'statement_agree.accepted' => 'Anda harus menyetujui pernyataan kebenaran data.',
            'program_study_2_id.different' => 'Pilihan Program Studi 2 tidak boleh sama dengan Pilihan 1.'
        ]);

        $user = Auth::user();
        
        if (!$user) {
            $user = User::where('email', $validated['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['phone']),
                    'phone' => $validated['phone'],
                    'role' => 'user'
                ]);
            }
            Auth::login($user);
        } else {
            $user->update([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);
        }

        $formData = $validated;
        unset($formData['program_study_id'], $formData['program_study_2_id'], $formData['registration_path_id'], $formData['captcha_answer'], $formData['statement_agree']);

        $wave = RegistrationWave::current()->first()
              ?? RegistrationWave::active()->first();


        $application = Application::updateOrCreate(
            ['user_id' => $user->id],
            [
                'program_study_id' => $validated['program_study_id'],
                'program_study_2_id' => $validated['program_study_2_id'] ?? null,
                'registration_path_id' => $validated['registration_path_id'],
                'registration_wave_id' => $wave ? $wave->id : null,
                'application_number' => 'PMB-'.date('Ymd').'-'.Str::upper(Str::random(4)),
                'status' => 'draft',
                'progress' => 100,
                'payment_status' => 'pending',
                'form_data' => $formData
            ]
        );

        // Kirim email konfirmasi & link cek status otomatis
        try {
            if ($user && $user->email) {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ApplicationSubmittedMail($application));
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim email pendaftaran: ' . $e->getMessage());
        }

        session()->forget('captcha_answer');

        return redirect()->route('dashboard')->with('success', 'Formulir pendaftaran berhasil dikirim. Email konfirmasi dan link cek status telah dikirimkan ke alamat email Anda.');
    }

    public function status(Request $request)
    {
        $search = trim($request->get('search', ''));
        $application = null;

        if (!empty($search)) {
            $application = Application::with(['programStudy', 'programStudy2', 'registrationPath', 'user'])
                ->where(function ($query) use ($search) {
                    $query->where('application_number', $search)
                        ->orWhere('form_data->nik', $search)
                        ->orWhere('form_data->email', $search)
                        ->orWhere('form_data->phone', $search);
                })
                ->latest()
                ->first();
        }

        return view('application.status', compact('application', 'search'));
    }
}
