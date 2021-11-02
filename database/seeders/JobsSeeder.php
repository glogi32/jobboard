<?php

namespace Database\Seeders;

use App\Enums\Seniority;
use App\Models\Area;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\Technology;
use Faker\Factory;
use Illuminate\Database\Seeder;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = Area::all();
        $cities = City::all();
        $techs = Technology::all();
        $companies = Company::all();
        $faker = Factory::create();

        foreach (Range(1,200) as $key => $value) {
            $job = new Job();
            $job->title = $faker->jobTitle();
            $job->vacancy = Rand(1,10);
            $job->deadline = time()+(60*60*60*24*Rand(7,65));
            $job->description = $faker->paragraphs(5, true);
            $job->responsibilities = $faker->paragraphs(Rand(2,6), true);
            $job->education_experience = $faker->paragraphs(Rand(2,6), true);
            $job->other_benefits = $faker->paragraphs(Rand(3,6), true);
            $job->employment_status = Rand(0,1);
            $job->seniority = Rand(0,3);
            $job->city_id = $cities->random()->id;
            $job->company_id = $companies->random()->id;
            $job->area_id = $areas->random()->id;
            $job->save();
        }
    }
}
