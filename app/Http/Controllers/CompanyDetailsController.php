<?php

namespace App\Http\Controllers;

use App\Enums\EmploymentStatus;
use App\Http\Requests\Companies\CommentRequest;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompanyDetailsController extends FrontController
{
    private $take;

    public function __construct()
    {
        $this->take = 5;
        session()->put("skip",0);
        session()->put("take",$this->take);
    }

    public function index($id)
    {
        $this->data["company"] = Company::with("logoImage","companyImages","user","city","user.role","user.image","comments","comments.user.image","jobs","jobs.technologies","jobs.city")->where("id",$id)->first();
        $this->data["company_comments"] = $this->data["company"]->comments->slice(0,$this->take);
        $this->data["emp_status"] = EmploymentStatus::asSelectArray();
        
        return view("pages.company-details",$this->data);
    }

    public function insertComment(CommentRequest $request)
    {
        $comment = new Comment();
        $comment->user_id = $request->input("userId");
        $comment->company_id = $request->input("companyId");
        $comment->text = $request->input("message");

        try {
            $comment->save();
            return response(["message" => "Comment successfully added."],200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error, try again later."],500);
        }
    }

    public function getAllCommentsForCompany(Request $request)
    {
        $companyId = $request->input("id");
        $skip = $request->input("skip");
        $take = $request->input("take");
        
        $company = Company::find($companyId);

        if(!$company){
            return response(["message" => "Company not found." ],404);
        }

        $comments = Comment::query();
        $comments = $comments->with("user","user.image")->where("company_id",$company->id)->orderBy("created_at","desc");

        $commentsCount = $comments->count();
        $paginateComments = $comments->skip((int)$skip)->take((int)$take)->get();
        

        foreach ($paginateComments as $c) {
            $c->createdAt = date("F j, Y \a\\t H:m",strtotime($c->created_at));
            $c->image = url($c->user->image->src);
        }

        return response(["comments" => $paginateComments,"commentsCount" => $commentsCount],200);
    }
}
