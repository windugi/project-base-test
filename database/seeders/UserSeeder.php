<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Apoteker Admin',
            'email' => 'apoteker@example.com',
            'password' => Hash::make('password123'),
            'role' => 'apoteker',
            'api_token' => '12345'
        ]);
    }
}
