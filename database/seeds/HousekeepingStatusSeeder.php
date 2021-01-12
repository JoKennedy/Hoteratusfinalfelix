<?php

use App\HousekeepingStatus;
use Illuminate\Database\Seeder;

class HousekeepingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HousekeepingStatus::create([
            'name'        => 'Touch-Up Rooms',
            'description' => 'Select color for the Touch-Up Rooms in the tape chart'
            ]);
        HousekeepingStatus::create([
            'name'        => 'Dirty Rooms',
            'description' => 'Select color for the Dirty Rooms in the tape chart'
        ]);
        HousekeepingStatus::create([
            'name'        => 'Inspect Rooms',
            'description' => 'Select color for the Inspect Rooms in the tape chart'
        ]);
        HousekeepingStatus::create([
            'name'        => 'Clean Rooms',
            'description' => 'Select color for the Clean Rooms in the tape chart'
        ]);
        HousekeepingStatus::create([
            'name'        => 'Repair Rooms',
            'description' => 'Select color for the Repair Rooms in the tape chart'
        ]);
        HousekeepingStatus::create([
            'name'        => 'Do Not Reserve (DNR)',
            'description' => 'Select color for the DNR Rooms in the tape chart'
        ]);
        HousekeepingStatus::create([
            'name'        => 'House Use Room',
            'description' => 'Select color for the House Use Room in the tape chart'
        ]);
    }
}
