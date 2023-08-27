<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function citiesPage()
    {
        return view("admin.pages.cities.cities");
    }
}
