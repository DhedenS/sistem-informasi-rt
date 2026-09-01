<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Household;
use App\Models\Block;

class HouseholdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blockA = Block::where('name', 'Blok A')->first();

        Household::firstOrCreate([
            'household_number' => 'A-001',
        ], [
            'block_id' => $blockA->id,
            'head_name' => 'Budi Santoso',
            'address' => 'Jl. Mawar No. 1',
            'phone' => '081234567890',
        ]);

        Household::firstOrCreate([
            'household_number' => 'A-002',
        ], [
            'block_id' => $blockA->id,
            'head_name' => 'Siti Aminah',
            'address' => 'Jl. Mawar No. 2',
            'phone' => '081234567891',
        ]);
    }
}
