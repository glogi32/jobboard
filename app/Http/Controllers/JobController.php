<?php

namespace App\Http\Controllers;

use App\Enums\Seniority;
use App\Models\Area;
use App\Models\City;
use App\Models\Technology;
use Illuminate\Http\Request;

class JobController extends FrontController
{
    public function index()
    {
        $this->data["seniorities"] = Seniority::asSelectArray();
        $this->data["areas"] = Area::all();
        $this->data["cities"] = City::all();
        $this->data["tech"] = Technology::all();
        
        return view("pages.jobs",$this->data);
    }
}
