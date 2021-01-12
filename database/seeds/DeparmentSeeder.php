<?php

use App\Department;
use Illuminate\Database\Seeder;

class DeparmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Tax'
         ]);
        Department::create([
            'name' => 'Fee'
        ]);
    }
}
