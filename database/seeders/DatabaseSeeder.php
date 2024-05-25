<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Medication;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        Medication::factory()->count(20)->create();
        Customer::factory()->count(10)->create();
    }
}
