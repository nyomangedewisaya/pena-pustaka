<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::forceCreate([
            'full_name' => 'Admin Pena Pustaka',
            'username' => 'admin-penpus',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);
    }
}
