<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('block_deposits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('block_id')
                ->constrained('blocks')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('month');
            $table->year('year');

            /*
             * Snapshot total pembayaran warga
             * saat Ketua Blok mengajukan setoran.
             */
            $table->decimal('expected_amount', 15, 2)->default(0);

            /*
             * Nominal uang yang benar-benar disetor.
             */
            $table->decimal('submitted_amount', 15, 2)->default(0);

            /*
             * submitted_amount - expected_amount
             */
            $table->decimal('difference', 15, 2)->default(0);

            $table->string('status')->default('pending');

            $table->text('notes')->nullable();

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['block_id', 'month', 'year'],
                'block_deposit_period_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('block_deposits');
    }
};