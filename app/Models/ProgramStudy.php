<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'level',
        'code',
        'description',
        'accreditation',
        'accreditation_sk_number',
        'accreditation_year',
        'accreditation_valid_from',
        'accreditation_valid_until',
        'accreditation_certificate_url',
        'image',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'accreditation_valid_from'  => 'date',
        'accreditation_valid_until' => 'date',
    ];

    public function fees()
    {
        return $this->hasMany(Fee::class);
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
