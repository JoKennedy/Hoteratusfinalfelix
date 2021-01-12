<?php

use App\AlphabetCoding;
use Illuminate\Database\Seeder;

class AlphabetCodingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AlphabetCoding::create([
            'name'        => 'Travel Agent Booking',
            'description' => 'Reservations received through Travel Agent',
            'default'     => 'T'
        ]);
        AlphabetCoding::create([
            'name'        => 'Corporate Booking',
            'description' => 'Reservations received through Corporates',
            'default'     => 'C'
        ]);
        AlphabetCoding::create([
            'name'        => 'Online/Web Booking',
            'description' => 'Reservations received through Website',
            'default'     => 'W'
        ]);
        AlphabetCoding::create([
            'name'        => 'Group Booking',
            'description' => 'Reservations received through Group',
            'default'     => 'G'
        ]);
        AlphabetCoding::create([
            'name'        => 'Other/GDS Booking',
            'description' => 'Reservations received through GDS',
            'default'     => 'O'
        ]);
        AlphabetCoding::create([
            'name'        => 'Rooms that have been Reserved & Assigned (A)',
            'description' => '',
            'default'     => 'A'
        ]);
    }
}
