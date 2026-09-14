<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_iuran_detail', function (Blueprint $table) {
            $table->id();

            // Pengajuan iuran
            $table->foreignId('pengajuan_iuran_id')
                ->constrained('pengajuan_iuran')
                ->cascadeOnDelete();

            // KK yang dipilih oleh Ketua Block
            $table->foreignId('household_id')
                ->constrained('households')
                ->cascadeOnDelete();

            $table->timestamps();

            // Satu KK tidak boleh tercatat dua kali
            // dalam pengajuan yang sama
            $table->unique([
                'pengajuan_iuran_id',
                'household_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_iuran_detail');
    }
};