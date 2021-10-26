<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends FrontController
{
    public function index($id){
        $user = User::with("role","image","user_main_cv")->where("id",$id)->first();
        if(!$user){
            return redirect()->back()->with("error",["title" => "Error","message" => "User doesn't exist"]);
        }

        $this->data["user"] = $user;

        return view("pages.user-profile",$this->data);
    }
}
