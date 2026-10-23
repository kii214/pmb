<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_study_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_path_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_wave_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->bigInteger('amount');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
