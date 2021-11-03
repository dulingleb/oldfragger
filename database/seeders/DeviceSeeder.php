<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devices')->insert([[
                'name' => 'iPhone SE',
                'os' => 1
            ], [
                'name' => 'Samsung Galaxy S10',
                'os' => 0
            ], [
                'name' => 'iPad Pro 12.9-in (5th generation)',
                'os' => 2
            ], [
                'name' => 'iPhone X',
                'os' => 1
            ], [
                'name' => 'iPhone 11',
                'os' => 1
            ]
        ]);
    }
}
