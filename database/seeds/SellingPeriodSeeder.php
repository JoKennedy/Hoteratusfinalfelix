<?php

use App\SellingPeriod;
use Illuminate\Database\Seeder;

class SellingPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellingPeriod::Create(['name' => 'Daily']);
        SellingPeriod::Create(['name' => 'Weekly']);
        SellingPeriod::Create(['name' => 'Monthly']);
    }
}
