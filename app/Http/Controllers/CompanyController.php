<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Enums\Seniority;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;

class CompanyController extends FrontController
{
    public function index()
    {   
        $this->data["cities"] = City::all();
        return view("pages.companies",$this->data);
    }
}
