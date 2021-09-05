<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = ["Belgrade","Novi Sad","Paris","Berlin"];
        
        foreach ($cities as $c) {
            $city = new City();
            $city->name = $c;
            $city->save();
        }
    }
}
