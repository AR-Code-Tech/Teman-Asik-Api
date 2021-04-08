<?php

namespace Database\Seeders;

use App\Models\Transportation;
use Illuminate\Database\Seeder;

class TransportationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transportation::create([
            'name' => 'Lyn A',
            'description' => 'Trmn. Gub. Suryo -- Nyai Ageng Pinatih -- Basuki Rahmat -- Pahlawan -- Veteran -- Trmn. Gulomantung -- (PP)'
        ]);
        Transportation::create([
            'name' => 'Lyn B',
            'description' => 'Trmn. Gubernur Suryo -- Usman Sadar -- Akom Kayat -- Pangsud -- Kartini -- Sekar Kurung -- (PP)'
        ]);
        Transportation::create([
            'name' => 'Lyn C',
            'description' => 'Trmn. Bunder -- Dr. Wahidin -- Pangsud -- J.A Suprapto -- Trmn. Gubernur Suryo -- (PP)'
        ]);
        Transportation::create([
            'name' => 'Lyn D',
            'description' => 'Trmn. Gub. Suryo -- Nyai Ageng Pinatih -- KH. Zubair -- J. A. Suprapto -- Dr. Sutomo -- Kapten Dulhasim -- (PP)'
        ]);
        Transportation::create([
            'name' => 'Lyn E',
            'description' => 'Trmn. Bunder -- Bunderan GKB -- Sunan Giri -- Kedanyang -- Mayjend Sungkono -- Veteran -- Darmo Sugondo -- (PP)'
        ]);
        Transportation::create([
            'name' => 'Lyn FG',
            'description' => "Bp. Wetan -- Pangsud -- A.R. Hakim -- Dr. Sutomo -- Wahidin -- GKB -- Pongangan -- KH. Syafi'i -- Trmn. Gubernur Suryo -- Harun Thohir -- (PP)"
        ]);
    }
}
