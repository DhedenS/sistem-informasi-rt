<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | ROLE YANG MEMANG DIPAKAI PROJECT
        |--------------------------------------------------------------------------
        */

        $roles = [
            'Superadmin',
            'Ketua RT',
            'Bendahara',
            'Perwakilan Blok',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | USER DUMMY
        |--------------------------------------------------------------------------
        */

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
                'email' => 'blok@rt.test',
                'role' => 'Perwakilan Blok',
            ],

        ];


        foreach ($users as $data) {

            $user = User::firstOrCreate(

                [
                    'email' => $data['email'],
                ],

                [
                    'name' => $data['name'],

                    'password' => bcrypt('password'),
                ]
            );

            $user->syncRoles([
                $data['role']
            ]);
        }


        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();
    }
}