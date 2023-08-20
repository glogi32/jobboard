<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentStatus;
use App\Enums\Seniority;
use App\Http\Requests\Jobs\JobApplicationRequest;
use App\Models\Application;
use App\Models\Job;
use App\Models\SavedJob;
use App\Models\User_cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobDetailsController extends FrontController
{

    public function index($id)
    {
        Job::find($id)->increment("statistics");
        $this->data["job"] = Job::with("company", "company.logoImage", "city", "technologies")->where("id", $id)->first();
        if (!$this->data["job"]) {
            return redirect()->back();
        }
        if (session()->has("user")) {
            $this->data["saved_job"] = SavedJob::where([
                ["user_id", "=", session("user")->id],
                ["job_id", "=", $this->data["job"]->id]
            ])->first();

            $this->data["job_applied"] = Application::where([
                ["user_id", "=", session("user")->id],
                ["job_id", "=", $id]
            ])->first();
        } else {
            $this->data["saved_job"] = null;
            $this->data["job_applied"] = null;
        }
        $this->data["emp_status"] = EmploymentStatus::asSelectArray();
        $this->data["description_array"] = explode("\r\n", $this->data["job"]->description);
        $this->data["responsibilities_array"] = explode("\r\n", $this->data["job"]->responsibilities);
        $this->data["education"] = explode("\r\n", $this->data["job"]->education_experience);
        $this->data["other_benefits"] = explode("\r\n", $this->data["job"]->other_benefits);
        $this->data["emp_status"] = EmploymentStatus::asSelectArray();
        $this->data["seniority"] = Seniority::asSelectArray();
        return view("pages.job-details", $this->data);
    }

    public function saveJob(Request $request)
    {
        $validated = $request->validate([
            'userId' => ["bail", "required", "exists:users,id"],
            'jobId' => ["bail", "required", "exists:jobs,id"]
        ]);

        $userId = $request->input("userId");
        $jobId = $request->input("jobId");

        $savedJobCheck = SavedJob::where([
            ["user_id", "=", $userId],
            ["job_id", "=", $jobId]
        ])->first();

        if ($savedJobCheck) {
            return response(["message" => "Job is already saved."], 409);
        }

        $savedJob = new SavedJob();
        $savedJob->user_id = $userId;
        $savedJob->job_id = $request->input("jobId");

        try {
            $savedJob->save();
            return response("", 204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error, try again later"], 500);
        }
    }

    public function unsaveJob(Request $request)
    {
        $validated = $request->validate([
            'userId' => ["bail", "required", "exists:users,id"],
            'jobId' => ["bail", "required", "exists:jobs,id"]
        ]);

        $userId = $request->input("userId");
        $jobId = $request->input("jobId");

        $savedJob = SavedJob::where([
            ["user_id", "=", $userId],
            ["job_id", "=", $jobId]
        ])->first();

        if (!$savedJob) {
            return response(["message" => "Job is not found.", 404]);
        }

        try {
            $savedJob->delete();
            return response("", 204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error, try again later"], 500);
        }
    }

    public function jobApplication(JobApplicationRequest $request)
    {

        $application = new Application();
        $application->message = $request->input("message");
        $application->status = ApplicationStatus::OnHold;
        $application->user_id = $request->input("userId");
        $application->job_id = $request->input("jobId");

        DB::beginTransaction();
        if (!$request->input("cv-apply")) {
            $fileCV = $request->file("cv");

            $fileName = time() . "_" . $fileCV->getClientOriginalName();
            $directory = \public_path() . "/user_cv-s";
            $path = "user_cv-s/" . $fileName;

            $fileUpload = $fileCV->move($directory, $fileName);

            $user_cv = new User_cv();
            $user_cv->name = $fileCV->getClientOriginalName();
            $user_cv->src = $path;
            $user_cv->user_id = $request->input("userId");
            $user_cv->main = false;
            $user_cv->save();
            $application->user_cv_id = $user_cv->id;
        } else {
            $application->user_cv_id = $request->input("user-cvs");
        }

        try {
            $application->save();
            DB::commit();
            return redirect()->back()->with("success", ["title" => "Success: ", "message" => "Your application has been successfully submitted."]);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return redirect()->back()->with("error", ["title" => "Error: ", "message" => "Server error, try again later."]);
        }
    }
}
