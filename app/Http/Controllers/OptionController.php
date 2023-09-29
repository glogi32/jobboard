<?php

namespace App\Http\Controllers;

use App\Enums\EmploymentStatus;
use App\Models\Company;
use App\Models\Job;
use App\Models\User_cv;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class OptionController extends FrontController
{
    public function index()
    {
        $this->data["page"] = "user-edit";
        $this->data["user_other_docs"] = User_cv::where([
            ["user_id", "=", session("user")->id],
            ["main", "=", false]
        ])->get();
        $this->data["user_main_cv"] = User_cv::where([
            ["user_id", "=", session("user")->id],
            ["main", "=", true]
        ])->first();
        return view("pages.options", $this->data);
    }

    public function companies()
    {
        $this->data["page"] = "companies";
        return view("pages.options", $this->data);
    }

    public function jobs()
    {
        $userCompanies = Company::where("user_id", session("user")->id)->get();
        $userCompaniesIds = Arr::pluck($userCompanies, "id");
        $this->data["jobs"] = Job::with("city", "company", "technologies")->whereIn("company_id", $userCompaniesIds)->orderBy("deadline", "asc")->get();
        $this->data["emp_status"] = EmploymentStatus::asSelectArray();
        $this->data["companies"] = $userCompanies;
        $this->data["page"] = "jobs";
        return view("pages.options", $this->data);
    }

    public function savedJobs()
    {

        $this->data["jobs"] = Job::with("city", "company", "technologies", "savedJobs")->whereHas("savedJobs", function ($query) {
            $query->where("user_id", "=", session("user")->id);
        })->orderBy("deadline", "asc")->get();

        $this->data["page"] = "saved-jobs";
        $this->data["emp_status"] = EmploymentStatus::asSelectArray();

        return view("pages.options", $this->data);
    }

    public function applications()
    {
        $userCompanies = Company::where("user_id", session("user")->id)->get();
        $userCompaniesIds = Arr::pluck($userCompanies, "id");
        $this->data["companies"] = $userCompanies;

        $this->data["page"] = "applications";
        return view("pages.options", $this->data);
    }

    public function removeUserCV($id)
    {
        $user_cv = User_cv::find($id);

        if (!$user_cv) {
            return redirect()->back()->with("error", ["title" => "Error", "message" => "User doesn't have uploaded main CV."]);
        }
        try {
            $user_cv->delete();

            session("user")->user_main_cv = null;
            return redirect()->back()->with("success", ["title" => "Success", "message" => "You successfuly removed main CV from your profile."]);
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with("error", ["title" => "Error", "message" => "Server error, try again later."]);
        }
    }

    public function removeUserDocs(Request $request)
    {

        $docs = User_cv::find($request->input("id"));

        if (!$docs) {
            return response()->json(["message" => "User doesn't have uploaded document."], 404);
        }

        try {
            $docs->delete();

            return response()->json(["message" => "You successfuly removed document from your profile."], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(["message" => "Server error, try again later"], 500);
        }
    }
}
