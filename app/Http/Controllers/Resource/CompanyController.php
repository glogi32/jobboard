<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\FrontController;
use App\Http\Requests\Companies\CompanyAddRequest;
use App\Http\Requests\Companies\CompanyEditRequest;
use App\Models\City;
use App\Models\Company;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyController extends FrontController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->input("userId");
        $orderBy = $request->input("orderBy","created_at");
        $order = $request->input("order","ASC");
        $keyword = $request->input("keyword");

        $cities = $request->input("city");
        $rating = $request->input("rating");

        $perPage = $request->input("perPage",5);
        $page = $request->input("page",1);

        $query = Company::with("logoImage","city")->withCount("comments");
        $response = [];

        if($userId){
            $query = $query->where("user_id",$userId);
        }

        if(!empty($keyword)){
            $query = $query->where("name","like","%".$keyword."%")
            ->orWhereHas("city",function($query) use($keyword){
                return $query->where("name","like","%".$keyword."%");
            });
        }

        if($cities){
            $query = $query->whereHas("city",function($query) use($cities){
                return $query->whereIn("id",$cities);
            });
        }

        if($rating){
            $query = $query->where("vote",">=",$rating);
        }

        if($order || $orderBy){
            $query = $query->orderBy($orderBy,$order);
        }

        try {
            if(!$userId){
                $skip = $perPage * ($page - 1); 
                $response["totalCompanies"] = $query->count();
                $response["totalPages"] = ceil($response["totalCompanies"]/$perPage);
                $response["curentPage"] = (int)$page;
                $response["nextPage"] = $response["totalPages"] - $page <= 0 ? false : true;
                $response["prevPage"] = $page <= 1 ? false : true;
                $response["skip"] = $skip+1;
                $response["companies"] = $query->skip($skip)->take($perPage)->get();
                $this->printStars($response["companies"]);
            }
            else{
                $response["companies"] = $query->get();
            }
            
            
            $this->formatCompanies($response["companies"]);
            return response(["data" => $response],200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            dd($th->getMessage());
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
        $this->data["page"] = "companyAdd";
        return view("pages.options",$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyAddRequest $request)
    {
        $userCompanies = Company::where("user_id",session("user")->id)->get();
        if(count($userCompanies) >= 5){
            return redirect()->back()->with("error",["title" => "Error: ", "message" => "You can have maximum 5 companies per account."]);
        }

        $company = new Company();
        $company->name = $request->input("name");
        $company->email = $request->input("email");
        $company->phone = $request->input("phone");
        $company->website = $request->input("website");
        $company->about_us = $request->input("about-us");
        $company->city_id = $request->input("city");
        $company->user_id = session("user")->id;

        DB::beginTransaction();

        try {
            $logo = $request->file("logo");
            $images = $request->file("images");
            $imageableType = "App\Models\Company";
         
            $company->save();

            if($logo){
                $imageName = time()."_".$logo->getClientOriginalName();
                $imageDirectory = \public_path()."/img/companies/logos";
                $pathLogo = "img/companies/logos/".$imageName;
                
                $imageUpload = $logo->move($imageDirectory,$imageName);

                $image = new Image();
                $image->src = $pathLogo;
                $image->alt = $imageName;
                $image->main = true;
                $image->imageable_type = $imageableType;
                $image->imageable_id = $company->id;

                $image->save();
            }
            if($images){
                foreach ($images as $img) {
                    $imageName = time()."_".$img->getClientOriginalName();
                    $imageDirectory = \public_path()."/img/companies";
                    $path = "img/companies/".$imageName;
                    
                    $imageUpload = $img->move($imageDirectory,$imageName);
    
                    $image = new Image();
                    $image->src = $path;
                    $image->alt = $imageName;
                    $image->main = false;
                    $image->imageable_type = $imageableType;
                    $image->imageable_id = $company->id;
    
                    $image->save();
                }
            }

            DB::commit();
            return redirect()->back()->with("success",["title" => "Success: ", "message" => "Company successfully added."]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with("error",["title" => "Error: ", "message" => "Server error on adding new company, try again later."]);
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
        $company = Company::with("logoImage")->where([
            ["id","=",$id],
            ["user_id","=",session("user")->id]
        ])->first();

        if(!$company){
            return redirect()->back();
        }

        
        $this->data["cities"] =  City::all();
        $this->data["company"] = $company;
        $this->data["page"] = "companyEdit";
        
        return view("pages.options",$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyEditRequest $request, $id)
    {
        $company = Company::where([
            ["id","=",$id],
            ["user_id","=",session("user")->id]
        ])->first();

        if(!$company){
            return redirect()->back();
        }

        $company->name = $request->input("name");
        $company->email = $request->input("email");
        $company->phone = $request->input("phone");
        $company->website = $request->input("website");
        $company->about_us = $request->input("about-us");
        $company->city_id = $request->input("city");
        
        DB::beginTransaction();
        
        $company->save();

        try {
            $logo = $request->file("logo");
            $images = $request->file("images");
            $imageableType = "App\Models\Company";

            if($logo){
                $imageName = time()."_".$logo->getClientOriginalName();
                $imageDirectory = \public_path()."/img/companies/logos";
                $pathLogo = "img/companies/logos/".$imageName;
                
                $imageUpload = $logo->move($imageDirectory,$imageName);

                $image = Image::where([
                    ["imageable_id","=",$id],
                    ["imageable_type","=",$imageableType],
                    ["main","=",true]
                ])->first();

                $this->deleteFile($image->src);

                $image->src = $pathLogo;
                $image->alt = $imageName;
                $image->main = true;
                $image->imageable_type = $imageableType;
                $image->imageable_id = $company->id;

                $image->save();
            }
            if($images){
                $images_db = Image::where([
                    ["imageable_id","=",$id],
                    ["imageable_type","=",$imageableType],
                    ["main","=",false]
                ])->get();
                foreach ($images_db as $img) {
                    $this->deleteFile($img->src);
                    $img->delete();
                }

                foreach ($images as $img) {
                    $imageName = time()."_".$img->getClientOriginalName();
                    $imageDirectory = \public_path()."/img/companies";
                    $path = "img/companies/".$imageName;
                    
                    $imageUpload = $img->move($imageDirectory,$imageName);
    
                    $image = new Image();
                    $image->src = $path;
                    $image->alt = $imageName;
                    $image->main = false;
                    $image->imageable_type = $imageableType;
                    $image->imageable_id = $company->id;
    
                    $image->save();
                }
            }

            DB::commit();
            return redirect()->back()->with("success",["title" => "Success: ", "message" => "Company successfully updated."]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with("error",["title" => "Error: ", "message" => "Server error on updating company, try again later."]);
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
        $company = Company::find($id);
        try {
            if(!$company){
                return response(["message" => "Company not found"],404);
            }
            $company->delete();
            return response(["message" => "Company successfully deleted"],204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error on deleteing company"],500);
        }
    }

    function formatCompanies($companies){
        foreach ($companies as $c) {
            $c->company_details = route("company-details",$c->id);
            $c->company_edit = route("companies.edit", $c->id);
            $c->logo_image_src = url($c->logoImage[0]->src);
            $c->logo_image_alt = $c->logoImage[0]->alt;
        }
    }
    public function printStars($companies)
    {
        foreach ($companies as $c) {
            $html = "";
            $vote = $c->vote;
            for ($i=1; $i <= 5; $i++) { 
                if($vote >= 1){
                    $html .= '<i class="fas fa-star star-color" ></i>';
                    $vote--;
                }
                else{
                    if($vote >= 0.5){
                        $html .= '<i class="fas fa-star-half-alt star-color" ></i>';
                        $vote -= 0.5;
                    }
                    else{
                        $html .= '<i class="far fa-star star-color" ></i>';
                    }
                }
            }
            $c->printed_stars = $html;
        }
    }
}
