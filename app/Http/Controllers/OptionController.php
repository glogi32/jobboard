<?php

namespace App\Http\Controllers;

use App\Enums\EmploymentStatus;
use App\Mail\VerificationMail;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class OptionController extends FrontController
{
    public function index()
    {
        $this->data["page"] = "user-edit";

        
        return view("pages.options",$this->data);
    }

    public function companies()
    {
        $this->data["page"] = "companies";
        return view("pages.options",$this->data);
    }

    public function jobs()
    {
        $userCompanies = Company::where("user_id",session("user")->id)->get();
        $userCompaniesIds = Arr::pluck($userCompanies,"id");
        $this->data["jobs"] = Job::with("city","company","technologies")->whereIn("company_id",$userCompaniesIds)->orderBy("deadline","asc")->get();
        $this->data["emp_status"] = EmploymentStatus::asSelectArray();
        $this->data["companies"] = $userCompanies;
        $this->data["page"] = "jobs";
        return view("pages.options",$this->data);
    }

    public function savedJobs()
    {
        
        $this->data["jobs"] = Job::with("city","company","technologies","savedJobs")->whereHas("savedJobs",function ($query){
            $query->where("user_id","=",session("user")->id);
        })->orderBy("deadline","asc")->get();

        $this->data["page"] = "saved-jobs";
        $this->data["emp_status"] = EmploymentStatus::asSelectArray();
        
        return view("pages.options",$this->data);
    }

    public function applications()
    {
        $userCompanies = Company::where("user_id",session("user")->id)->get();
        $userCompaniesIds = Arr::pluck($userCompanies,"id");
        $this->data["companies"] = $userCompanies;
        
        $this->data["page"] = "applications";
        return view("pages.options",$this->data);
    }

    
}
