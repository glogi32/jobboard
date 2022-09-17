<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\City;
use Illuminate\Http\Request;

class CompaniesController extends FrontController
{
    public function companiesPage(Request $request)
    {
        $this->data["cities"] = City::all();

        return view("admin.pages.companies.companies",$this->data);
    }
}
