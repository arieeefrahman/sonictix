<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();

        User::create([
            'full_name' => 'Testing User',
            'email' => 'testing@example.com',
            'username' => 'testing',
            'password' => Hash::make('testing'),
        ]);
    }
}
