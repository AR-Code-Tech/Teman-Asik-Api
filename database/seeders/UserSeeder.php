<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Example Driver',
            'username' => 'driver',
            'password' => Hash::make('driver')
        ]);
        User::create([
            'name' => 'Example Admin',
            'role' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin')
        ]);
    }
}
