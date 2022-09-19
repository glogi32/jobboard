<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\City;
use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends FrontController
{
    public function companiesPage(Request $request)
    {
        $this->data["cities"] = City::all();

        return view("admin.pages.companies.companies",$this->data);
    }

    public function topCompaniesStatistics()
    {
        $companiesStats = Company::select("name","statistics")->orderBy("statistics","DESC")->limit(10)->get();

        if(!$companiesStats){
            return response()->json(["message" => "Companies not found"],404);
        }
        return response()->json(["data" => $companiesStats]);
    }
}
