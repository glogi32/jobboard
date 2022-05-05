<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Job;
use App\Models\User_cv;
use Illuminate\Database\Seeder;
use Faker\Factory;

class ApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCVS = User_cv::all();
        $jobs = Job::all();
        $faker = Factory::create();

        foreach (Range(1,1500) as $key => $value) {
            $oneCv = $userCVS->random();
            $app = new Application();
            $app->message = $faker->sentence(15);
            $app->status = rand(0,2);
            $app->user_cv_id = $oneCv->id;
            $app->user_id = $oneCv->user_id;
            $app->job_id = $jobs->random()->id;
            $app->save();
        }
    }
}
