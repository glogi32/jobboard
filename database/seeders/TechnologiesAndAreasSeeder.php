<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologiesAndAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = ["Backend","Frontend","Fullstack","DevOps","QA","UX UI Design","SysAdmin","Others"];

        $technologies = ["HTML","CSS","Bootstrap","PHP",".NET",".NET Core","C#","JavaScript","Java","SOLID","Spring","Laravel","VueJS","React","Angular","SQL","XML","NoSQL"];

        foreach ($areas as $a) {
            $area = new Area();
            $area->name = $a;
            $area->save();
        }

        foreach ($technologies as $t) {
            $tech = new Technology();
            $tech->name = $t;
            $tech->save();
        }
    }
}
