<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;

class UsersController extends FrontController
{
    //
    public function usersPage(Request $request)
    {
        return view("admin.pages.users.users");
    }
}
