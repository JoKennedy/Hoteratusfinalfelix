<?php

use App\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'name' => 'English',
            'code' => 'en'
        ]);
        Language::create([
            'name' => 'Español',
            'code' => 'es'
        ]);
        Language::create([
            'name' => 'Italian',
            'code' => 'it'
        ]);
        Language::create([
            'name' => 'French',
            'code' => 'fr'
        ]);
        Language::create([
            'name' => 'German',
            'code' => 'ge'
        ]);
    }
}

