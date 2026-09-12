<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_iuran', function (Blueprint $table) {
            $table->id();

            // Blok yang mengajukan iuran
            $table->foreignId('block_id')
                ->constrained('blocks')
                ->cascadeOnDelete();

            // Ketua Block yang membuat pengajuan
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Periode iuran
            $table->unsignedTinyInteger('bulan');
            $table->unsignedSmallInteger('tahun');

            // Nominal iuran per KK
            $table->decimal('nominal_per_kk', 15, 2);

            // Total seluruh iuran
            $table->decimal('total_iuran', 15, 2);

            // Bukti pembayaran/penyerahan uang
            $table->string('bukti')->nullable();

            // Status pengajuan
            $table->enum('status', [
                'Menunggu Verifikasi',
                'Disetujui',
                'Ditolak',
            ])->default('Menunggu Verifikasi');

            // Catatan
            $table->text('catatan')->nullable();

            // Bendahara yang melakukan verifikasi
            $table->foreignId('diverifikasi_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Waktu verifikasi
            $table->timestamp('diverifikasi_pada')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_iuran');
    }
};