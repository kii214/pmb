<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('payment_status');
            $table->text('admin_notes')->nullable()->after('form_data');
        });

        Schema::table('contact_settings', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('whatsapp_message')->default('BCA');
            $table->string('bank_account')->nullable()->after('bank_name')->default('1234567890');
            $table->string('account_name')->nullable()->after('bank_account')->default('STMIK ROSMA');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['payment_proof', 'admin_notes']);
        });

        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account', 'account_name']);
        });
    }
};
