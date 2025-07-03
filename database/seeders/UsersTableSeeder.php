<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Principal',
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),
                'user_type' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Inspecteur Exemple',
                'email' => 'inspecteur@example.com',
                'password' => Hash::make('123456'),
                'user_type' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
