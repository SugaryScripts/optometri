<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $this->call([
            StaffSeeder::class,
            BrandSeeder::class,
            //ProductSeeder::class,
            SecondProductSeeder::class,
            ProductImageSeeder::class,
        ]);
    }
}
