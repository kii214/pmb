<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registration_waves', function (Blueprint $table) {
            $table->boolean('is_current')->default(false)->after('sort_order')
                  ->comment('Gelombang yang sedang aktif menerima pendaftaran (hanya 1 yang boleh true)');
        });
    }

    public function down(): void
    {
        Schema::table('registration_waves', function (Blueprint $table) {
            $table->dropColumn('is_current');
        });
    }
};
