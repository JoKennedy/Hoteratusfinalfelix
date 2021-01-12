<?php

use App\PropertyDepartment;
use Illuminate\Database\Seeder;

class PropertyDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PropertyDepartment::firstOrCreate([
            'name' => 'Sales',
            'code' => 'Sales',
            'description' => 'Sales'
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Purchase',
            'code' => 'Purchase',
            'description' => 'Purchase',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'KST',
            'code' => 'KST',
            'description' => 'KST',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'IT',
            'code' => 'IT',
            'description' => 'IT',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'HR',
            'code' => 'HR',
            'description' => 'HR',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Housekeeping',
            'code' => 'Housekeeping',
            'description' => 'Housekeeping',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Front Office',
            'code' => 'Front Office',
            'description' => 'Front Office',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Finance',
            'code' => 'Finance',
            'description' => 'Finance',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'F&B Service',
            'code' => 'F&B Service',
            'description' => 'F&B Service',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'F&B Production',
            'code' => 'F&B Production',
            'description' => 'F&B Production',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Engineering',
            'code' => 'Engineering',
            'description' => 'Engineering',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Billing',
            'code' => 'Billing',
            'description' => 'Billing',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Tax',
            'code' => 'Tax',
            'description' => 'Tax',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Account',
            'code' => 'Account',
            'description' => 'Account',
        ]);
        PropertyDepartment::firstOrCreate([
            'name' => 'Default Account',
            'code' => 'Default Account',
            'description' => 'Default Account',
        ]);
    }
}
