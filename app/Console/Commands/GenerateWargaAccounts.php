<?php

namespace App\Console\Commands;

use App\Models\Household;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateWargaAccounts extends Command
{
    protected $signature = 'warga:generate-accounts';
    protected $description = 'Generate akun Warga otomatis untuk tiap KK yang belum punya akun';

    public function handle()
    {
        $households = Household::whereDoesntHave('user')->where('is_active', true)->get();

        if ($households->isEmpty()) {
            $this->info('Semua KK sudah punya akun Warga.');
            return;
        }

        $rows = [];

        foreach ($households as $household) {
            $code = strtoupper(str_replace(['-', ' '], '', $household->household_number));

            preg_match('/^([A-Z]+)(\d+)$/', $code, $matches);
            $password = isset($matches[1], $matches[2])
                ? $matches[2] . $matches[1]
                : $code;

            $emailSlug = strtolower(str_replace(['-', ' '], '', $household->household_number));
            $email = $emailSlug . '@warga.rt';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $household->head_name,
                    'password' => bcrypt($password),
                    'household_id' => $household->id,
                ]
            );

            if (!$user->household_id) {
                $user->update(['household_id' => $household->id]);
            }

            $user->syncRoles(['Warga']);

            $rows[] = [$household->household_number, $household->head_name, $email, $password];
        }

        $this->table(['No. Rumah', 'Nama', 'Email', 'Password Awal'], $rows);
        $this->info(count($rows) . ' akun Warga berhasil dibuat/diperbarui.');
    }
}
