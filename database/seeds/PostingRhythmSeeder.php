<?php

use App\PostingRhythm;
use Illuminate\Database\Seeder;

class PostingRhythmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostingRhythm::firstOrCreate([
            'name' => 'Everyday'
        ]);
        PostingRhythm::firstOrCreate([
            'name' => 'Everyday but Check-in'
        ]);
        PostingRhythm::firstOrCreate([
            'name' => 'Everyday but Check-out'
        ]);
        PostingRhythm::firstOrCreate([
            'name' => 'Check-in and Check-out'
        ]);
        PostingRhythm::firstOrCreate([
            'name' => 'Only on Check-in'
        ]);
        PostingRhythm::firstOrCreate([
            'name' => 'Only on Check-out'
        ]);
        PostingRhythm::firstOrCreate([
            'name' => 'Charge Once'
        ]);
        PostingRhythm::firstOrCreate([
            'name' => 'Everyday but check-in check-out'
        ]);
        PostingRhythm::firstOrCreate([
            'name' => 'Quantity Based'
        ]);
    }
}
