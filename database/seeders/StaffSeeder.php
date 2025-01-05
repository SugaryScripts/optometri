<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //Staff::factory(5)->create();
        Staff::factory(5)
            ->hasUser()
            ->create();

        User::factory(10)->create();
    }
}
