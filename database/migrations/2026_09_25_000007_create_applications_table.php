<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_study_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('registration_path_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('registration_wave_id')->nullable()->constrained()->nullOnDelete();
            $table->string('application_number')->unique()->nullable();
            $table->string('status')->default('draft');
            $table->integer('progress')->default(0);
            $table->json('form_data')->nullable();
            $table->string('payment_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
