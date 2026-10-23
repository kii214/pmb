<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('image')->nullable()->after('slug');
            $table->string('category')->default('Berita')->after('image');
            $table->string('badge_color')->default('primary')->after('category');
            $table->boolean('is_featured')->default(false)->after('badge_color');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['image', 'category', 'badge_color', 'is_featured']);
        });
    }
};
