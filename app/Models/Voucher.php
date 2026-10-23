<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'amount',
        'discount_type',
        'target_fee',
        'valid_until',
        'status',
        'description',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'amount' => 'decimal:2',
    ];

    public function isValid()
    {
        if ($this->status !== 'active') {
            return false;
        }
        
        if ($this->valid_until && $this->valid_until->isPast()) {
            return false;
        }

        return true;
    }
}
