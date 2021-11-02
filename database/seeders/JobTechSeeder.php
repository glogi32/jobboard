<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobTechnology;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class JobTechSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tech = Technology::all();
        $jobs = Job::all();

        foreach ($jobs as $job) {
            foreach (Range(1,Rand(3,5)) as $t) {
                $jobTech = new JobTechnology();
                $jobTech->technology_id = $tech->random()->id;
                $jobTech->job_id = $job->id;
                $jobTech->save();
            }
        }
    }
}
