<?php

use App\CalculationRule;
use Illuminate\Database\Seeder;

class CalculationRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CalculationRule::firstOrCreate([
            'name' => 'Per Adult'
        ]);
        CalculationRule::firstOrCreate([
            'name' => 'Per Child'
        ]);
        CalculationRule::firstOrCreate([
            'name' => 'Per Person'
        ]);
        CalculationRule::firstOrCreate([
            'name' => 'Per Baby'
        ]);
        CalculationRule::firstOrCreate([
            'name' => 'Per Room'
        ]);
    }
}
