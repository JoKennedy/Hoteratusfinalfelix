<?php

use App\RoomStatus;
use Illuminate\Database\Seeder;

class RoomStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomStatus::create([
            'name' => 'Reserved Rooms',
            'description' => 'Select color for the reserved rooms in the tape chart'
        ]);
        RoomStatus::create([
            'name' => 'Checked-in Rooms',
            'description' => 'Select color for the Checked-in rooms in the tape chart'
        ]);
        RoomStatus::create([
            'name' => 'Checked-out Rooms',
            'description' => 'Select color for the checked out rooms in the tape chart'
        ]);
        RoomStatus::create([
            'name' => 'Temp Rooms',
            'description' => 'Select color for the temp room in the tape chart'
        ]);
        RoomStatus::create([
            'name' => 'Overbooked Rooms',
            'description' => 'Select color for the overbooked room in the tape chart'
        ]);
    }
}
