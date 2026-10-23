<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_name',
        'campus_name',
        'whatsapp_number',
        'whatsapp_message',
        'bank_name',
        'bank_account',
        'account_name',
        'email',
        'address',
        'hero_image',
        'hero_caption',
        'status',
    ];
}
