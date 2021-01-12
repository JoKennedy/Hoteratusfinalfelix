<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(SalutationSeeder::class);
        $this->call(DeparmentSeeder::class);
        $this->call(TaxAppliedSeeder::class);
        $this->call(RoomStatusSeeder::class);
        $this->call(HousekeepingStatusSeeder::class);
        $this->call(AlphabetCodingSeeder::class);
    }
}
