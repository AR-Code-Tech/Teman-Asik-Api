<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Driver;
use App\Models\Transportation;
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
        $driver = Driver::create([
            'transportation_id' => 1,
            'identity_number' => '023132564412',
            'plate_number' => '123321'
        ]);
        $driver->user()->create([
            'name' => 'Example Driver',
            'username' => 'driver',
            'password' => Hash::make('driver')
        ]);

        (Admin::create([]))->user()->create([
            'name' => 'Example Admin',
            'username' => 'admin',
            'password' => Hash::make('admin')
        ]);
    }
}
