<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;

class JobsController extends FrontController
{
    public function jobsPage(Request $request)
    {
        return view("admin.pages.users.jobs",$this->data);
    }
}
