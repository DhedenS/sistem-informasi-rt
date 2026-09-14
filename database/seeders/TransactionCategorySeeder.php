<?php

namespace Database\Seeders;

use App\Models\TransactionCategory;
use Illuminate\Database\Seeder;

class TransactionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Pemasukan
            ['name' => 'Iuran Warga', 'type' => 'masuk', 'is_active' => true],
            ['name' => 'Dana CSR', 'type' => 'masuk', 'is_active' => true],
            ['name' => 'Sumbangan', 'type' => 'masuk', 'is_active' => true],
            ['name' => 'Bantuan Pemerintah', 'type' => 'masuk', 'is_active' => true],
            ['name' => 'Lain-lain', 'type' => 'masuk', 'is_active' => true],

            // Pengeluaran
            ['name' => 'Keamanan', 'type' => 'keluar', 'is_active' => true],
            ['name' => 'Kebersihan', 'type' => 'keluar', 'is_active' => true],
            ['name' => 'Infrastruktur', 'type' => 'keluar', 'is_active' => true],
            ['name' => 'Sosial & Kegiatan', 'type' => 'keluar', 'is_active' => true],
            ['name' => 'Administrasi & Operasional', 'type' => 'keluar', 'is_active' => true],
            ['name' => 'Lain-lain', 'type' => 'keluar', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            TransactionCategory::firstOrCreate(
                ['name' => $cat['name'], 'type' => $cat['type']],
                $cat
            );
        }
    }
}
