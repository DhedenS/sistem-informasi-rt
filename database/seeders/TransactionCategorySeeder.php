<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransactionCategory;

class TransactionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Kategori pemasukan
            ['name' => 'Iuran Warga', 'type' => 'masuk'],
            ['name' => 'Dana CSR', 'type' => 'masuk'],
            ['name' => 'Sumbangan', 'type' => 'masuk'],
            ['name' => 'Bantuan Pemerintah', 'type' => 'masuk'],
            ['name' => 'Lain-lain', 'type' => 'masuk'],

            // Kategori pengeluaran
            ['name' => 'Keamanan', 'type' => 'keluar'],
            ['name' => 'Kebersihan', 'type' => 'keluar'],
            ['name' => 'Infrastruktur', 'type' => 'keluar'],
            ['name' => 'Sosial & Kegiatan', 'type' => 'keluar'],
            ['name' => 'Administrasi & Operasional', 'type' => 'keluar'],
            ['name' => 'Lain-lain', 'type' => 'keluar'],
        ];

        foreach ($categories as $category) {
            TransactionCategory::firstOrCreate($category);
        }
    }
}
