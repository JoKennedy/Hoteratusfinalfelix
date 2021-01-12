<?php

use App\Salutation;
use Illuminate\Database\Seeder;

class SalutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Salutation::create([
            'name' => 'Dr.',
            'active' => 1
        ]);
        Salutation::create([
            'name' => 'Mr.',
            'active' => 1
        ]);
        Salutation::create([
            'name' => 'Mrs.',
            'active' => 1
        ]);
        Salutation::create([
            'name' => 'Ms.',
            'active' => 1
        ]);
    }
}
