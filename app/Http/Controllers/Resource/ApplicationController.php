<?php

namespace App\Http\Controllers\Resource;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentStatus;
use App\Enums\Seniority;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->input("userId");
        $role = $request->input("role");
        $companyId = $request->input("companyId");
        $orderBy = $request->input("orderBy", "created_at");
        $order = $request->input("order", "ASC");
        $keyword = $request->input("keyword");
        $perPage = $request->input("perPage", 5);
        $page = $request->input("page", 1);

        DB::enableQueryLog();
        $query = Application::with("user", "user_cv", "job", "job.company");

        if ($role) {
            if ($role == "Employer") {
                $userCompanies = Company::where("user_id", $userId)->get();
                $userCompaniesIds = Arr::pluck($userCompanies, "id");
                $query = $query->whereHas("job", function ($query) use ($userCompaniesIds) {
                    return $query->whereIn("company_id", $userCompaniesIds);
                });
            } else if ($role == "Candidate") {
                $query = $query->where("user_id", $userId);
            }
        }
        if ($companyId) {
            $query = $query->whereHas("job", function ($query) use ($companyId) {
                return $query->where("company_id", $companyId);
            });
        }
        if ($keyword) {
            $query = $query->whereHas("job", function ($query) use ($keyword) {
                return $query->where("title", "like", "%" . $keyword . "%");
            })
                ->orWhereHas("job.company", function ($query) use ($keyword) {
                    return $query->where("name", "like", "%" . $keyword . "%");
                });
        }
        if ($orderBy && $order) {
            $query = $query->orderBy($orderBy, $order);
        }

        try {
            $skip = $perPage * ($page - 1);
            $response["totalApplications"] = $query->count();
            $response["totalPages"] = ceil($response["totalApplications"] / $perPage);
            $response["curentPage"] = (int)$page;
            $response["nextPage"] = $response["totalPages"] - $page <= 0 ? false : true;
            $response["prevPage"] = $page <= 1 ? false : true;
            $response["skip"] = $skip + 1;
            $response["applications"] = $query->skip($skip)->take($perPage)->get();

            $this->formatApplications($response["applications"]);

            return response($response, 200);
        } catch (\Throwable $th) {
            // dd($th);
            Log::error($th->getMessage());
            return response()->json(["message" => "Server error on getting applications, try again later"], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $application = Application::with("user", "user.image", "user_cv", "job", "job.company", "job.city")->find($id);
            $application->job_url = route("job-details", $application->user->id);
            $application->company_url = route("company-details", $application->job->company->id);
            $application->app_status = ApplicationStatus::asSelectArray();
            $application->seniority = Seniority::asSelectArray();
            $application->applied_at = date("d-M-Y", strtotime($application->created_at));
            $application->user_image = url($application->user->image->src);
            $application->user_profile = route("user-profile", $application->user->id);
            $application->userCV = url($application->user_cv->src);
            return response()->json(["data" => $application], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["message" => "Server error on getting application, try again later"], 500);
        }
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
        $app = Application::find($id);
        if (!$app) {
            return response()->json(["message" => "Application not found."], 404);
        }
        $appStatus = $request->input("appStatus");
        $app->status = $appStatus;

        try {
            $app->save();
            return response()->json("", 204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["message" => "Server error on changing application status, try again later."], 500);
        }
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
    public function formatApplications($data)
    {
        $applicationStatus = ApplicationStatus::asSelectArray();
        foreach ($data as $a) {
            $a->status_name = $applicationStatus[$a->status];
            $a->applied_at = date("d-M-Y", strtotime($a->created_at));
            $a->job_url = route("job-details", $a->job->id);
            $a->company_url = route("company-details", $a->job->company->id);
        }
    }
}
