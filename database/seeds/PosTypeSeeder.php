<?php

use App\PosType;
use Illuminate\Database\Seeder;

class PosTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PosType::firstOrCreate(['name'=> 'Restaurant']);
        PosType::firstOrCreate(['name'=> 'Bar']);
        PosType::firstOrCreate(['name'=> 'Spa']);
        PosType::firstOrCreate(['name'=> 'Tour']);
        PosType::firstOrCreate(['name' => 'Shop']);
    }
}
