<?php

namespace App\Http\Controllers\Resource;

use App\Enums\EmploymentStatus;
use App\Enums\JobStatus;
use App\Enums\Seniority;
use App\Http\Controllers\Controller;
use App\Http\Requests\Jobs\JobAddRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobTechnology;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->input("userId");
        $companyId = $request->input("companyId");
        $orderBy = $request->input("orderBy","deadline");
        $order = $request->input("order","ASC");
        $keyword = $request->input("keyword");

        $seniorites = $request->input("seniorites");
        $areas = $request->input("areas");
        $cities = $request->input("cities");
        $techs = $request->input("techs");

        $perPage = $request->input("perPage",5);
        $page = $request->input("page",1);

        $pageType = $request->input("pageType");
        $response = [];

        
        
        

        $query = Job::with("city","company","company.logoImage","technologies","area");

        if($companyId){
            $query->where("company_id",$companyId);
        }else if(!$companyId && $pageType == "user-jobs"){

            $userCompanies = Company::where("user_id",$userId)->get();
            $userCompaniesIds = Arr::pluck($userCompanies,"id");
            $query->whereIn("company_id",$userCompaniesIds);
        }

        if(!empty($keyword)){
           $query = $query->where("title","like","%".$keyword."%")
                ->orWhereHas("area",function($query) use($keyword){
                    $query->where("name","like","%".$keyword."%");
                })
                ->orWhereHas("company",function($query) use($keyword){
                    $query->where("name","like","%".$keyword."%");
                });
        }

        
        if($seniorites){
            $query = $query->whereIn("seniority",$seniorites);
        }
        if($techs){
            $query = $query->whereHas("technologies", function($query) use($techs){
                return $query->whereIn("technology_id",$techs);
            });
        }
        if($cities){
            $query = $query->whereHas("city",function($query) use($cities){
                return $query->whereIn("id",$cities);
            });
        }
        if($areas){
            $query = $query->whereIn("area_id",$areas);
        }

        if($order || $orderBy){
            $query = $query->orderBy($orderBy,$order);
        }

        if($pageType == "jobs"){
            $query = $query->where("deadline",">",time());
        }
        try {
            $skip = $perPage * ($page - 1);
            $response["totalJobs"] = $query->count();
            $response["totalPages"] = ceil($response["totalJobs"]/$perPage);
            $response["curentPage"] = (int)$page;
            $response["nextPage"] = $response["totalPages"] - $page <= 0 ? false : true;
            $response["prevPage"] = $page <= 1 ? false : true;
            $response["skip"] = $skip+1;
            $response["jobs"] = $query->skip($skip)->take($perPage)->get();
            
            if($pageType == "adminJobs"){
                $this->formatAdminJobs($response["jobs"],$response["skip"]);
            }
            else{
                $this->formatJobs($response["jobs"]);
            }

            return response($response,200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error, try again later."],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $this->data["cities"] =  City::all();
        $this->data["seniorities"] = Seniority::asArray();
        $this->data["emp_status"] = EmploymentStatus::asArray();
        $this->data["companies"] = Company::where("user_id",session("user")->id)->get();
        $this->data["technologies"] = Technology::get();
        $this->data["areas"] = Area::all();
        $this->data["page"] = "jobAdd";
        return view("pages.options",$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobAddRequest $request)
    {
        $jobsFromCompany = Job::where("company_id",$request->input("company"))->get();

        if(count($jobsFromCompany) >= 10){
            return redirect()->back()->with("error",["title" => "Error: ", "message" => "You can have maximum of 10 jobs per company."]);
        }
        

        $jobTechs = $request->input("tech");
        $job = new Job();
        $job->title = $request->input("title");
        $job->vacancy = $request->input("vacancy");
        $job->deadline = (int)strtotime($request->input("deadline"));
        $job->description = $request->input("description");
        $job->responsibilities = $request->input("responsibilities");
        $job->education_experience = $request->input("education");
        $job->other_benefits = $request->input("benefits");
        $job->employment_status = $request->input("empStatus");
        $job->seniority = $request->input("seniority");
        $job->city_id = $request->input("city");
        $job->company_id = $request->input("company");
        $job->area_id = $request->input("area");

        DB::beginTransaction();
        $job->save();

        foreach ($jobTechs as $techId) {
            $jobTech = new JobTechnology();
            $jobTech->job_id = $job->id;
            $jobTech->technology_id = $techId;
            $jobTech->save();
        }

        try {
            DB::commit();
            return redirect()->back()->with("success",["title" => "Success: ", "message" => "Job successfully added."]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            DB::rollBack();
            return redirect()->back()->with("error",["title" => "Error: ", "message" => "Server error, try again later"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function formatJobs($jobs)
    {
        $empStatus = EmploymentStatus::asSelectArray();
        foreach ($jobs as $j) {
            $j->job_details = route("job-details",$j->id);
            $j->company_details = route("company-details",$j->company->id);
            $j->emp_status = $empStatus[$j->employment_status];
            $j->deadline_formated = ceil(($j->deadline - time())/60/60/24) <= 0 ? "Expired" : ceil(($j->deadline - time())/60/60/24);
            $j->companyLogo = url($j->company->logoImage[0]->src);
        }
    }

    public function formatAdminJobs($jobs, $skip = 1)
    {
        $empStatus = EmploymentStatus::asSelectArray();
        $seniority = Seniority::asSelectArray();
        foreach ($jobs as $j) {
            $j->listNumber = $skip;
            $skip++;
            $j->job_details = route("job-details",$j->id);
            $j->company_details = route("company-details",$j->company->id);
            $j->emp_status = $empStatus[$j->employment_status];
            $j->seniority = $seniority[$j->seniority];
            $j->deadline_formated = date("d-m-Y H:i", $j->deadline);

            if(ceil(($j->deadline - time())/60/60/24) <= 0){
                $j->status = '<span class="badge bg-warning">Expired</span>';
            }
            else if($j->deleted_at){
                $j->status = '<span class="badge bg-danger">Deleted</span>';
            }
            else{
                $j->status = '<span class="badge bg-success">Active</span>';
            }

            $j->created_at_formated = date("d-m-Y H:i", $j->created_at->timestamp);
            
            if($j->created_at->timestamp == $j->updated_at->timestamp){
                $j->updated_at_formated = null;
            }
            else{
                $j->updated_at_formated = date("d-m-Y H:i", $j->updated_at->timestamp);
            }
        }
    }
}
