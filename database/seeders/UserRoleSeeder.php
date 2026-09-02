<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@rt.test',
                'role' => 'Superadmin',
            ],
            [
                'name' => 'Ketua RT',
                'email' => 'ketuart@rt.test',
                'role' => 'Ketua RT',
            ],
            [
                'name' => 'Bendahara',
                'email' => 'bendahara@rt.test',
                'role' => 'Bendahara',
            ],
            [
                'name' => 'Perwakilan Blok A',
                'email' => 'perwakilan@rt.test',
                'role' => 'Perwakilan Blok',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password'),
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
