<?php

namespace Database\Seeders;

use App\Models\FundSource;
use Illuminate\Database\Seeder;

class FundSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            ['name' => 'Iuran Warga', 'description' => 'Rutin/bulanan', 'is_active' => true],
            ['name' => 'Dana CSR / Hibah Perusahaan', 'description' => 'Insidental', 'is_active' => true],
            ['name' => 'Sumbangan Sukarela Warga', 'description' => 'Insidental', 'is_active' => true],
            ['name' => 'Bantuan Pemerintah (Kelurahan/Kecamatan)', 'description' => 'Insidental', 'is_active' => true],
            ['name' => 'Hasil Usaha/Aset RT', 'description' => 'Insidental', 'is_active' => true],
            ['name' => 'Lain-lain', 'description' => 'Sesuai kebutuhan', 'is_active' => true],
        ];

        foreach ($sources as $source) {
            FundSource::firstOrCreate(['name' => $source['name']], $source);
        }
    }
}
