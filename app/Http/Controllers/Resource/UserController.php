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
        $orderBy = $request->input("orderBy", "created_at");
        $order = $request->input("order", "DESC");
        $keyword = $request->input("keyword");

        $status = $request->input("status");
        $role = $request->input("role");
        $verificationRangeFrom = $request->input("verificationRangeFrom");
        $verificationRangeTo = $request->input("verificationRangeTo");
        $createRangeFrom = $request->input("createRangeFrom");
        $createRangeTo = $request->input("createRangeTo");
        $updateRangeFrom = $request->input("updateRangeFrom");
        $updateRangeTo = $request->input("updateRangeTo");

        $perPage = $request->input("perPage", 5);
        $page = $request->input("page", 1);

        $pageType = $request->input("pageType");
        $response = [];

        $query = User::with("role:id,name");

        if ($role) {
            $query = $query->where("role_id", $role);
        }
        if ($status) {
            if ($status == "Deleted") {
                $query = $query->whereNotNull("deleted_at");
            } else if ($status == "Pending") {
                $query = $query->where("verified", null);
            } else {
                $query = $query->where("deleted_at", null)
                    ->whereNotNull("verified");
            }
        }

        if ($verificationRangeFrom && $verificationRangeTo) {

            $query = $query->where("verified", ">", strtotime(str_replace("/", "-", $verificationRangeFrom)));
            $query = $query->where("verified", "<", strtotime(str_replace("/", "-", $verificationRangeTo)));
        }


        if ($createRangeFrom && $createRangeTo) {

            $createRangeFromTimestamp = strtotime(str_replace("/", "-", $createRangeFrom));
            $createRangeToTimestamp = strtotime(str_replace("/", "-", $createRangeTo));

            $query = $query->where("created_at", ">", date("Y-m-d", $createRangeFromTimestamp));
            $query = $query->where("created_at", "<", date("Y-m-d", $createRangeToTimestamp));
        }

        if ($updateRangeFrom && $updateRangeTo) {

            $updateRangeFromTimestamp = strtotime(str_replace("/", "-", $updateRangeFrom));
            $updateRangeToTimestamp = strtotime(str_replace("/", "-", $updateRangeTo));

            $query = $query->where("created_at", ">", date("Y-m-d", $updateRangeFromTimestamp));
            $query = $query->where("created_at", "<", date("Y-m-d", $updateRangeToTimestamp));
        }

        if (!empty($keyword)) {
            $query = $query->where("first_name", "like", "%" . $keyword . "%")
                ->orWhere(function ($query) use ($keyword) {
                    $query->where("last_name", "like", "%" . $keyword . "%");
                })
                ->orWhere(function ($query) use ($keyword) {
                    $query->where("email", "like", "%" . $keyword . "%");
                });
        }

        if ($order || $orderBy) {
            $query = $query->orderBy($orderBy, $order);
        }

        try {
            $skip = $perPage * ($page - 1);
            $response["totalUsers"] = $query->count();
            $response["totalPages"] = ceil($response["totalUsers"] / $perPage);
            $response["curentPage"] = (int)$page;
            $response["nextPage"] = $response["totalPages"] - $page <= 0 ? false : true;
            $response["prevPage"] = $page <= 1 ? false : true;
            $response["skip"] = $skip + 1;
            if ($pageType == "adminUsers") {
                $response["users"] = $query->skip($skip)->take($perPage)->withTrashed()->get();
            } else {
                $response["users"] = $query->skip($skip)->take($perPage)->get();
            }



            $this->formatUsers($response["users"], $response["skip"]);
            return response($response, 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error, try again later."], 500);
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
        $user = User::with("image", "user_main_cv", "user_other_docs")->find($id);

        if (!$user) {
            return redirect()->back()->with("error", ["title" => "Error", "message" => "User not found."]);
        }

        $role_id = $request->input("role");

        if (!$role_id) {
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

            if ($fileCV) {
                $fileName = time() . "_" . $fileCV->getClientOriginalName();
                $directory = \public_path() . "/user_cv-s";
                $path = "user_cv-s/" . $fileName;

                $fileUpload = $fileCV->move($directory, $fileName);

                if ($user->user_main_cv) {
                    $user_cv = User_cv::find($user->user_main_cv->id);
                    $user_cv->name = $fileCV->getClientOriginalName();
                    $user_cv->src = $path;
                    $user_cv->user_id = $user->id;
                    $user_cv->main = true;
                    $user_cv->save();
                } else {
                    $user_cv = new User_cv();
                    $user_cv->name = $fileCV->getClientOriginalName();
                    $user_cv->src = $path;
                    $user_cv->main = true;
                    $user_cv->user_id = $user->id;
                    $user_cv->save();
                }
            }

            if ($fileDocs) {
                $directory = \public_path() . "/user_cv-s";
                $user_docs_ids = Arr::pluck($user->user_other_docs, "id");
                User_cv::whereIn("id", $user_docs_ids)->delete();

                foreach ($fileDocs as $docs) {
                    $fileName = time() . "_" . $docs->getClientOriginalName();
                    $path = "user_cv-s/" . $fileName;

                    $fileUpload = $docs->move($directory, $fileName);

                    $user_cv = new User_cv();
                    $user_cv->name = $docs->getClientOriginalName();
                    $user_cv->src = $path;
                    $user_cv->main = false;
                    $user_cv->user_id = $user->id;
                    $user_cv->save();
                }
            }
            $updateUser = $user->save();

            if ($fileImage) {
                $imageName = time() . "_" . $fileImage->getClientOriginalName();
                $image_directory = \public_path() . "/img/users";
                $path = "img/users/" . $imageName;
                $imageable_type = "App\Models\User";

                $imageUpload = $fileImage->move($image_directory, $imageName);
                $this->deleteFile($user->image->src);

                $image = Image::where("imageable_id", $user->id)->first();
                $image->src = $path;
                $image->alt = $imageName;
                $image->imageable_type = $imageable_type;
                $image->imageable_id = $user->id;
                $image->save();
            }

            DB::commit();
            $user = User::with("role", "image")->where("id", $id)->first();
            session()->put("user", $user);
            return redirect()->back()->with("success", ["title" => "Success", "message" => "User data successfully updated."]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->back()->with("error", ["title" => "Error", "message" => "Server error, try again later."]);
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
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "User not found!"], 404);
        }

        try {
            $user->delete();
            return response(["message" => "User successfully deleted"], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error on deleteing user"], 500);
        }
    }

    public function formatUsers($users, $skip = 1)
    {
        foreach ($users as $key => $user) {

            $user->listNumber = $skip;
            $skip++;
            $user->userAdminEditUrl = route("user-edit-admin", $user->id);
            if ($user->verified) {
                $user->verified = date("d.m.Y H:i", $user->verified);
            }

            if ($user->deleted_at) {
                $user->deleted_at_formated = date("d.m.Y H:i", strtotime($user->deleted_at));
            } else {
                $user->deleted_at_formated = null;
            }

            $user->created_at_formated = date("d.m.Y H:i", $user->created_at->timestamp);

            if ($user->created_at->timestamp == $user->updated_at->timestamp) {
                $user->updated_at_formated = null;
            } else {
                $user->updated_at_formated = date("d.m.Y H:i", $user->updated_at->timestamp);
            }

            // $user->user_url = route("user-profile", $user->id);
            $user->user_url = url("user-profile/" . $user->id);

            if ($user->verified && !$user->deleted_at) {
                $user->status = '<span class="badge bg-success">Active</span>';
            }

            if (!$user->verified) {
                $user->status = '<span class="badge bg-warning">Pending</span>';
            }

            if ($user->deleted_at) {
                $user->status = '<span class="badge bg-danger">Deleted</span>';
            }
        }
    }
}
