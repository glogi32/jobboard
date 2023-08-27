<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TechnologiesController extends Controller
{
    public function technologiesPage()
    {
        return view("admin.pages.technologies.technologies");
    }
}
