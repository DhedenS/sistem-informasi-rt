<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Ketua RT', 'email' => 'ketuart@rt.test', 'role' => 'Ketua RT'],
            ['name' => 'Bendahara', 'email' => 'bendahara@rt.test', 'role' => 'Bendahara'],
            ['name' => 'Sekretaris', 'email' => 'sekretaris@rt.test', 'role' => 'Sekretaris'],
            ['name' => 'Ketua Block A', 'email' => 'ketuablock@rt.test', 'role' => 'Ketua Block'],
            ['name' => 'Warga Contoh', 'email' => 'warga@rt.test', 'role' => 'Warga'],
        ];

        $blockA = \App\Models\Block::first();

        foreach ($users as $data) {
            $userData = [
                'name' => $data['name'],
                'password' => bcrypt('password'),
            ];

            if ($data['role'] === 'Ketua Block' && $blockA) {
                $userData['block_id'] = $blockA->id;
            }

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                $userData
            );

            if ($data['role'] === 'Ketua Block' && $blockA && !$user->block_id) {
                $user->update(['block_id' => $blockA->id]);
            }

            $user->syncRoles([$data['role']]);
        }
    }
}
