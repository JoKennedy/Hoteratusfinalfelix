<?php

use App\TaxApplied;
use Illuminate\Database\Seeder;

class TaxAppliedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaxApplied::create([
            'name' => 'On Published Rack Rate',
            'tax_type_id'=> 1
        ]);
        TaxApplied::create([
            'name' => 'On Room Tariff Charged',
            'tax_type_id' => 1
        ]);
        TaxApplied::create([
            'name' => 'Per Reservation',
            'tax_type_id' => 2
        ]);
        TaxApplied::create([
            'name' => 'Per Night',
            'tax_type_id' => 2
        ]);
        TaxApplied::create([
            'name' => 'Per Person Per Night',
            'tax_type_id' => 2
        ]);
        TaxApplied::create([
            'name' => 'Per Person',
            'tax_type_id' => 2
        ]);
    }
}
