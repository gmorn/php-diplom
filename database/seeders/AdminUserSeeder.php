<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'number' => '123',
            'password' => Hash::make('123123'), // Обязательно замените на безопасный пароль
            'rating' => 0,
            'reviewCount' => 0,
            'images' => '',
            'status' => false,
            'isAdmin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
