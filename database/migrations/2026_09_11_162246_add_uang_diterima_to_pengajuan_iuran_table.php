<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengajuan_iuran', function (Blueprint $table) {
            $table->decimal('uang_diterima', 15, 2)
                ->nullable()
                ->after('total_iuran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_iuran', function (Blueprint $table) {
            $table->dropColumn('uang_diterima');
        });
    }
};