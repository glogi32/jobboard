<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Seniority;
use App\Http\Controllers\FrontController;
use App\Models\Area;
use App\Models\City;
use App\Models\Job;
use App\Models\Technology;
use Illuminate\Http\Request;

class JobsController extends FrontController
{
    public function jobsPage(Request $request)
    {
        $this->data["seniorities"] = Seniority::asSelectArray();
        $this->data["areas"] = Area::all();
        $this->data["cities"] = City::all();
        $this->data["tech"] = Technology::all();

        return view("admin.pages.jobs.jobs", $this->data);
    }

    public function topJobsStatistics()
    {
        $jobsStats = Job::select("title", "statistics")->orderBy("statistics", "DESC")->limit(10)->get();

        if (!$jobsStats) {
            return response()->json(["message" => "Jobs not found"], 404);
        }
        return response()->json(["data" => $jobsStats]);
    }
}
