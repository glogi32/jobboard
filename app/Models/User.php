<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory,SoftDeletes;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user_cvs()
    {
        return $this->hasMany(User_cv::class);
    }

    public function user_main_cv()
    {
        return $this->hasOne(User_cv::class)->where("main",true);
    }

    public function user_other_docs()
    {
        return $this->hasMany(User_cv::class)->where("main",false);
    }

    public function image(){
        return $this->morphOne(Image::class,"imageable");
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function comments()
    {       
        return $this->hasMany(Comment::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(User::class);
    }
}
