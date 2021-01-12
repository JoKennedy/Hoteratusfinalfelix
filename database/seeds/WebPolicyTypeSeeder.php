<?php

use App\WebPolicyType;
use Illuminate\Database\Seeder;

class WebPolicyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WebPolicyType::create(['name' => 'Deposit']);
        WebPolicyType::create(['name' => 'Credit Card Guarantee']);
        WebPolicyType::create(['name' => 'Do not Require Deposit Or Credit Card']);

    }
}
