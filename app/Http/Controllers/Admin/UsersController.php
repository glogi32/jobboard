<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Role;
use Illuminate\Http\Request;

class UsersController extends FrontController
{
    //
    public function usersPage(Request $request)
    {
        $this->data["roles"] = Role::all();
        
        return view("admin.pages.users.users",$this->data);
    }
}
