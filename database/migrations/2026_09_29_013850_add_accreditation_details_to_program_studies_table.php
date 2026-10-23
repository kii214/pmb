<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->string('accreditation_sk_number')->nullable()->after('accreditation');
            $table->year('accreditation_year')->nullable()->after('accreditation_sk_number');
            $table->date('accreditation_valid_from')->nullable()->after('accreditation_year');
            $table->date('accreditation_valid_until')->nullable()->after('accreditation_valid_from');
            $table->string('accreditation_certificate_url')->nullable()->after('accreditation_valid_until');
        });
    }

    public function down(): void
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->dropColumn([
                'accreditation_sk_number',
                'accreditation_year',
                'accreditation_valid_from',
                'accreditation_valid_until',
                'accreditation_certificate_url',
            ]);
        });
    }
};
