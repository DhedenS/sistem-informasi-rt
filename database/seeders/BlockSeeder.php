<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Block;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blocks = ['Blok A', 'Blok B', 'Blok C'];

        foreach ($blocks as $name) {
            Block::firstOrCreate(['name' => $name], ['code' => str_replace('Blok ', '', $name)]);
        }
    }
}
