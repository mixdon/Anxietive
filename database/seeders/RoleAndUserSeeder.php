<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Insert Roles
            DB::table('tb_roles')->insert([
                [
                    'id' => 1,
                    'role' => 'SUPER_ADMIN',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'role' => 'ADMIN',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            // Insert Users
            DB::table('tb_user')->insert([
                [
                    'username' => 'superadmin',
                    'password' => Hash::make('password'),
                    'fullname' => 'Super Admin',
                    'office' => null,
                    'roles' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'username' => 'admin1',
                    'password' => Hash::make('password'),
                    'fullname' => 'Admin Cempedak I',
                    'office' => 1,
                    'roles' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'username' => 'admin2',
                    'password' => Hash::make('password'),
                    'fullname' => 'Admin Delima',
                    'office' => 2,
                    'roles' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'username' => 'admin3',
                    'password' => Hash::make('password'),
                    'fullname' => 'Admin KS Tubun',
                    'office' => 3,
                    'roles' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        });
    }
}