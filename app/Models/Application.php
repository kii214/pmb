<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_study_id',
        'program_study_2_id',
        'registration_path_id',
        'registration_wave_id',
        'application_number',
        'status',
        'progress',
        'form_data',
        'payment_status',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programStudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'program_study_id');
    }

    public function programStudy2()
    {
        return $this->belongsTo(ProgramStudy::class, 'program_study_2_id');
    }

    public function registrationPath()
    {
        return $this->belongsTo(RegistrationPath::class, 'registration_path_id');
    }

    public function registrationWave()
    {
        return $this->belongsTo(RegistrationWave::class, 'registration_wave_id');
    }
}
