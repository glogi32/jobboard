<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\UserRequest;
use App\Models\Company;
use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use App\Models\User_cv;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends FrontController
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
        $orderBy = $request->input("orderBy","created_at");
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


        $query = User::with("role:id,name");

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
            $response["totalUsers"] = $query->count();
            $response["totalPages"] = ceil($response["totalUsers"]/$perPage);
            $response["curentPage"] = (int)$page;
            $response["nextPage"] = $response["totalPages"] - $page <= 0 ? false : true;
            $response["prevPage"] = $page <= 1 ? false : true;
            $response["skip"] = $skip+1;
            $response["users"] = $query->skip($skip)->take($perPage)->get();
            // }else{
            //     $response["jobs"] = $query->get();
            // }
            

            $this->formatUsers($response["users"]);
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
    public function update(UserRequest $request, $id)
    {
        
        $user = User::with("image","user_main_cv","user_other_docs")->find($id);

        if(!$user){
            return redirect()->back()->with("error",["title" => "Error","message" => "User not found."]);
        }

        $role_id = $request->input("role");
        if(!$role_id){
            $role_id = $user->role_id;
        }

        $user->first_name = $request->input("first-name");
        $user->last_name = $request->input("last-name");
        $user->email = $request->input("email");
        $user->password = md5($request->input("password"));
        $user->phone = $request->input("phone");
        $user->linkedin = $request->input("linkedin");
        $user->github = $request->input("github");
        $user->portfolio_link = $request->input("portfolio-website");
        $user->about_me = $request->input("about-u");
        $user->role_id = $role_id;
        
        DB::beginTransaction();
        
        try {
            $fileCV = $request->file("cv");
            $fileDocs = $request->file("other-docs");
            $fileImage = $request->file("image");

            if($fileCV){
                $fileName = time()."_".$fileCV->getClientOriginalName();
                $directory = \public_path()."/user_cv-s";
                $path = "user_cv-s/".$fileName;

                $fileUpload = $fileCV->move($directory,$fileName);

                if($user->user_main_cv){
                    $user_cv = User_cv::find($user->user_main_cv->id);
                    $user_cv->name = $fileCV->getClientOriginalName();
                    $user_cv->src = $path;
                    $user_cv->user_id = $user->id;
                    $user_cv->main = true;
                    $user_cv->save();
                }else{
                    $user_cv = new User_cv();
                    $user_cv->name = $fileCV->getClientOriginalName();
                    $user_cv->src = $path;
                    $user_cv->main = true;
                    $user_cv->user_id = $user->id;
                    $user_cv->save();
                }
            }

            if($fileDocs){
                $directory = \public_path()."/user_cv-s";
                $user_docs_ids = Arr::pluck($user->user_other_docs,"id");
                User_cv::whereIn("id",$user_docs_ids)->delete();

                foreach ($fileDocs as $docs) {
                    $fileName = time()."_".$docs->getClientOriginalName();
                    $path = "user_cv-s/".$fileName;

                    $fileUpload = $docs->move($directory,$fileName);

                    $user_cv = new User_cv();
                    $user_cv->name = $docs->getClientOriginalName();
                    $user_cv->src = $path;
                    $user_cv->main = false;
                    $user_cv->user_id = $user->id;
                    $user_cv->save();
                }
            }
            $updateUser = $user->save();

            if($fileImage){
                $imageName = time()."_".$fileImage->getClientOriginalName();
                $image_directory = \public_path()."/img/users";
                $path = "img/users/".$imageName;
                $imageable_type = "App\Models\User";

                $imageUpload = $fileImage->move($image_directory,$imageName);
                $this->deleteFile($user->image->src);

                $image = Image::where("imageable_id",$user->id)->first();
                $image->src = $path;
                $image->alt = $imageName;
                $image->imageable_type = $imageable_type;
                $image->imageable_id = $user->id;
                $image->save();
            }

            DB::commit();
            $user = User::with("role","image")->where("id",$id)->first();
            session()->put("user",$user);
            return redirect()->back()->with("success",["title" => "Success","message" => "User data successfully updated."]);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->back()->with("error",["title" => "Error","message" => "Server error, try again later."]);
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

    public function formatUsers($users)
    {
        foreach ($users as $key => $user) {
            if($user->verified){
                $user->verified = date("d-m-Y H:i", $user->verified);
            }

            if($user->deleted_at){
                $user->deleted_at = date("d-m-Y H:i", strtotime($user->deleted_at));
            }

            $user->created_at = date("d-m-Y H:i", strtotime($user->created_at));

            if($user->created_at == $user->updated_at){
                $user->updated_at = null;
            }
            else{
                $user->updated_at = date("d-m-Y H:i", strtotime($user->updated_at));
            }

            $user->user_url = route("user-profile", $user->id);
                    
        }
    }

    
}
