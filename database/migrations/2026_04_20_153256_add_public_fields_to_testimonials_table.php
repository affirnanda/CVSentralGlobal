<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Nama pengirim testimoni (dari landing page)
            $table->string('name')->nullable()->after('id');
            // Rating bintang 1-5
            $table->unsignedTinyInteger('rating')->default(5)->after('message');
            // Status: disetujui admin untuk ditampilkan
            $table->boolean('is_approved')->default(false)->after('rating');
            // Buat project_client_id optional (untuk testimoni dari publik)
            $table->foreignId('project_client_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['name', 'rating', 'is_approved']);
            $table->foreignId('project_client_id')->nullable(false)->change();
        });
    }
};
