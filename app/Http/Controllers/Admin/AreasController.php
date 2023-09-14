<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function areasPage()
    {
        return view('admin.pages.areas.areas');
    }
}
