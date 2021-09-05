<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Mail\VerificationMail;
use App\Models\Image;
use App\Models\User;
use App\Models\User_cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{


    public function signUp(SignUpRequest $request){
        
        $user = new User();
        $user->first_name = $request->input("first-name");
        $user->last_name = $request->input("last-name");
        $user->email = $request->input("email");
        $user->password = md5($request->input("password"));
        $user->phone = $request->input("phone");
        $user->linkedin = $request->input("linkedin");
        $user->github = $request->input("github");
        $user->portfolio_link = $request->input("portfolio-website");
        $user->about_me = $request->input("about-u");
        $user->verification_number = rand(10000,10000000);

        $user->role_id = 2;

        DB::beginTransaction();
        
        try {
            $fileCV = $request->file("cv");
            $fileImage = $request->file("image");
            if($fileCV){
                $fileName = time()."_".$fileCV->getClientOriginalName();
                $directory = \public_path()."/user_cv-s";
                $path = "user_cv-s/".$fileName;

                $fileUpload = $fileCV->move($directory,$fileName);
                
                

                $user_cv = new User_cv();
                $user_cv->name = $fileCV->getClientOriginalName();
                $user_cv->src = $path;
                $user_cv->save();
                $user->user_cvs_id = $user_cv->id;
            }
            
            $userInsert = $user->save();

            if($fileImage){
                $imageName = time()."_".$fileImage->getClientOriginalName();
                $image_directory = \public_path()."/img/users";
                $path = "img/users/".$imageName;
                $imageable_type = "App\Models\User";

                $imageUpload = $fileImage->move($image_directory,$imageName);

                $image = new Image();
                $image->src = $path;
                $image->alt = $imageName;
                $image->imageable_type = $imageable_type;
                $image->imageable_id = $user->id;
                $image->save();
            }
            
            DB::commit();

            
            Mail::to($user->email)->send(new VerificationMail($user->verification_number));

            
            return redirect()->back()->with("success",["title" => "Success: ", "message" => "Successfull sign up, check your email so u can verify your account."]);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            if(File::exists($path)) {

                File::delete($path);
            }
            return redirect()->back()->with("error" ,["title" => "Error","message" => "Server error on sign up, try again later."])->withInput();
        }
        
        
        
    }


    public function login(Request $request){
        $email = $request->input("email");
        $password = md5($request->input("password"));

        try {
            $user = User::with("role","image","user_cvs")->where([
                ["email","=",$email],
                ["password","=",$password]
            ])->first();

            if(!empty($user)){

                if(!$user->verified){
                    session()->put("verificationError","Your account has not been verified, check your email.");
                    return redirect()->back()->with("error",["title" => "Error login: ","message" => "Your account has not been verified."]);
                }
                else{
                    if(session()->has("verificationError")){
                        session()->forget("verificationError");
                    }
                }

                session()->put("user",$user);
                return redirect()->back()->with("success",["title" => "Success: ","message" => "Login is successful."]);
            }
            else{
                return redirect()->back()->with("error",["title" => "Error login: ","message" => "Wrong credentials."])->withInput();
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with("error",["title" => "Error: ","message" => "Server error, try again later."])->withInput();
        }
    }

    
    public function logout()
    {
        if(session()->has("user")){
            session()->forget("user");
        }
        
        return redirect("/");
    }

    public function verifyAccount(Request $request){
        $verification_number = $request->input("key");

        $user = User::where("verification_number",$verification_number)->first();

        if($user){
            $user->verified = time();
            
            try {
                $user->save();
                return redirect('/login')->with("success",["title" => "Success: ","message" => "You successfully verified your account, you can log in now."]);
                
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return redirect('/login')->with("success",["error" => "Success: ","message" => "Server error, contact our adminstrators."]);
            }
        }else{
            Log::error("User tryed to verify account with verification number ".$verification_number.". Ip address: ".$request->ip().", at time:". date("d-m-Y H:i:s",time()));
            return redirect('/login')->with("success",["error" => "Success: ","message" => "Server error, contact our adminstrators."]);
        }
    }
}
