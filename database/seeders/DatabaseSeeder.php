<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            CitySeeder::class,
            CompaniesSeeder::class,
            TechnologiesAndAreasSeeder::class,
            JobsSeeder::class,
            JobTechSeeder::class,
            ApplicationsSeeder::class,
            
            
        ]);

    }
}
