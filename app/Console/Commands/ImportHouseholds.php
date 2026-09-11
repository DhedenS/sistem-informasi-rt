<?php

namespace App\Console\Commands;

use App\Models\Block;
use App\Models\Household;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportHouseholds extends Command
{
    protected $signature = 'households:import {file}';
    protected $description = 'Import data KK dari file Excel (sheet DAFTAR IPL)';

    public function handle()
    {
        $path = $this->argument('file');

        if (!file_exists($path)) {
            $this->error("File tidak ditemukan: $path");
            return 1;
        }

        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getSheetByName('DAFTAR IPL');

        if (!$sheet) {
            $this->error('Sheet "DAFTAR IPL" tidak ditemukan.');
            return 1;
        }

        $rows = $sheet->toArray(null, true, true, true);

        $imported = 0;
        $skipped = 0;

        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex <= 3) continue;

            $name = trim((string) ($row['B'] ?? ''));
            $houseNumber = trim((string) ($row['C'] ?? ''));

            if ($name === '' || $houseNumber === '') {
                $skipped++;
                continue;
            }

            preg_match('/^([A-Za-z]+)/', $houseNumber, $matches);
            $blockCode = isset($matches[1]) ? strtoupper($matches[1]) : null;

            if (!$blockCode) {
                $skipped++;
                continue;
            }

            $block = Block::firstOrCreate(
                ['code' => $blockCode],
                ['name' => 'Blok ' . $blockCode, 'is_active' => true]
            );

            $normalized = preg_replace('/^([A-Za-z]+)[\s\-]*0*(\d+)$/', '$1-$2', $houseNumber);
            $normalized = strtoupper($normalized);

            if (Household::where('household_number', $normalized)->exists()) {
                $skipped++;
                continue;
            }

            Household::create([
                'block_id' => $block->id,
                'household_number' => $normalized,
                'head_name' => $name,
                'is_active' => true,
            ]);

            $imported++;
        }

        $this->info("Import selesai: {$imported} KK berhasil diimport, {$skipped} baris dilewati (kosong/duplikat/tanpa nomor rumah).");
        return 0;
    }
}
