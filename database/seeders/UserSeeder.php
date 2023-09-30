<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::insert([
            [
                'name' => 'Admin User',
                'user_role_id' => 1,
                'email' => 'admin@gmail.com',
                'password' => bcrypt(123456),
            ],
            [
                'name' => 'Demo User',
                'user_role_id' => 2,
                'email' => 'demouser@gmail.com',
                'password' => bcrypt(123456),
            ],
        ]);
    }
}
