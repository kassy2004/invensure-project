<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
       
            'name' => 'ian',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Always hash passwords
            'role' => 'admin', // if you added a 'roles' column
        ]);
    }
}
