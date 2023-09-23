<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Company;
use App\Models\Image;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $cities = City::all();
        $faker = Factory::create();
        $companyImages = [
            'img\home\job_logo_1.jpg'
        ];

        for ($i = 0; $i < 25; $i++) {
            $company = new Company();
            $company->name = $faker->company();
            $company->email = $faker->email();
            $company->website = $faker->url();
            $company->phone = $faker->phoneNumber();
            $company->about_us = $faker->paragraphs(Rand(1, 5), true);
            $company->vote = rand(1 * 10, 5 * 10) / 10;
            $company->user_id = $users->random()->id;
            $company->city_id = $cities->random()->id;
            $company->save();
            $companyImage = new Image();
            $companyImage->alt = $faker->word(1);
            $companyImage->src = $faker->imageUrl(150, 150);
            $companyImage->main = 1;
            $companyImage->imageable_id = $company->id;
            $companyImage->imageable_type = "App\Models\Company";
            $companyImage->save();
            foreach (Range(1, 4) as $key => $value) {
                $companyImage = new Image();
                $companyImage->alt = $faker->word(1);
                $companyImage->src = $faker->imageUrl(150, 150);
                $companyImage->main = 0;
                $companyImage->imageable_id = $company->id;
                $companyImage->imageable_type = "App\Models\Company";
                $companyImage->save();
            }
        }
    }
}
