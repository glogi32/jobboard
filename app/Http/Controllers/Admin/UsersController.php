<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends FrontController
{
    //
    public function usersPage(Request $request)
    {
        $this->data["roles"] = Role::all();
           
        return view("admin.pages.users.users", $this->data);
    }

    public function usersEditPage(Request $request,$id)
    {   
        $user = User::with("image","user_main_cv","user_other_docs")->find($id);

        if(!$user){
            return redirect()->back()->with("error",["title" => "Error","message" => "User not found."]);
        }
        $this->data["user"] = $user;
        
        return view("admin.pages.users.user-edit", $this->data);
    }
}
