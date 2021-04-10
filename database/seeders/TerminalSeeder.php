<?php

namespace Database\Seeders;

use App\Models\Terminal;
use Illuminate\Database\Seeder;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Terminal::create([
            'name' => 'Sub Terminal Menganti',
            'latitude' => -7.294310092783217,
            'longitude' => 112.5879419352882,
        ]);
        Terminal::create([
            'name' => 'Terminal Menganti',
            'latitude' => -7.294588031029851,
            'longitude' => 112.58795768022537,
        ]);
        Terminal::create([
            'name' => 'Terminal Bunder',
            'latitude' => -7.17018209900659,
            'longitude' => 112.58387870356603,
        ]);
    }
}
