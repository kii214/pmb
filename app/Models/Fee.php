<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_study_id',
        'registration_path_id',
        'registration_wave_id',
        'name',
        'amount',
        'start_date',
        'end_date',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'integer',
    ];

    public function programStudy()
    {
        return $this->belongsTo(ProgramStudy::class);
    }

    public function path()
    {
        return $this->belongsTo(RegistrationPath::class, 'registration_path_id');
    }

    public function wave()
    {
        return $this->belongsTo(RegistrationWave::class, 'registration_wave_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('sort_order');
    }
}
