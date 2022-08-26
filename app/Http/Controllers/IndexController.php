<?php

namespace App\Http\Controllers;

use App\Enums\EmploymentStatus;
use App\Models\Company;
use App\Models\Job;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends FrontController
{
    public function index()
    {
        $jobs = Job::with("city","company","company.logoImage","technologies","area")->where("deadline",">",time())->orderBy("statistics","DESC")->limit(6)->get();
        $empStatus = EmploymentStatus::asSelectArray();

        foreach ($jobs as $j) {
            $j->job_details = route("job-details",$j->id);
            $j->company_details = route("company-details",$j->company->id);
            $j->emp_status = $empStatus[$j->employment_status];
            $j->deadline_formated = ceil(($j->deadline-time())/60/60/24) <= 0 ? "Expired" : ceil(($j->deadline-time())/60/60/24);
            $j->companyLogo = url($j->company->logoImage[0]->src);
        }

        $this->data["featuredJobs"] = $jobs;
        $this->data["candidates"] = User::where("role_id",2)->count();
        $this->data["jobsPosted"] = Job::where("deadline",">",time())->count();
        $this->data["jobsFilled"] = Job::count();
        $this->data["companies"] = Company::count();
        $this->data["tags"] = Technology::inRandomOrder()->limit(3)->select("name")->get();
        
        return view("pages.home",$this->data);
    }
}
