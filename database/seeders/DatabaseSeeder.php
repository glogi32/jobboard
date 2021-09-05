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
        $roles = ["Admin","Candidate","Employer"];
        
        foreach ($roles as $r) {
            $role = new Role();
            $role->name = $r;
            $role->save();
        }


    }
}
