<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
