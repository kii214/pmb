<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPath extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'sort_order'];

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
