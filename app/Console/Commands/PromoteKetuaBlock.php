<?php

namespace App\Console\Commands;

use App\Models\Block;
use App\Models\User;
use Illuminate\Console\Command;

class PromoteKetuaBlock extends Command
{
    protected $signature = 'ketuablock:promote-placeholder';
    protected $description = 'Promote KK pertama di tiap blok jadi Ketua Block (placeholder sementara)';

    public function handle()
    {
        $blocks = Block::with(['households' => function ($q) {
            $q->where('is_active', true)->orderBy('household_number');
        }])->get();

        $rows = [];

        foreach ($blocks as $block) {
            $firstHousehold = $block->households->first();

            if (!$firstHousehold) {
                $this->warn("Blok {$block->code} tidak punya KK aktif, dilewati.");
                continue;
            }

            $user = User::where('household_id', $firstHousehold->id)->first();

            if (!$user) {
                $this->warn("KK {$firstHousehold->household_number} belum punya akun Warga, dilewati.");
                continue;
            }

            $user->update(['block_id' => $block->id]);
            $user->assignRole('Ketua Block');

            $rows[] = [$block->code, $firstHousehold->household_number, $user->name, $user->email];
        }

        $this->table(['Blok', 'No. KK', 'Nama', 'Email (login)'], $rows);
        $this->info(count($rows) . ' Ketua Block placeholder berhasil di-assign.');
    }
}
