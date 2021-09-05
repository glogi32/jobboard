<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logoImage()
    {
        return $this->morphMany(Image::class,"imageable")->where("main",1);
    }

    public function companyImages()
    {
        return $this->morphMany(Image::class,"imageable")->where("main",0);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy("created_at","desc");
    }

    public function jobs()
    {
        return $this->hasMany(Job::class)->where("deadline",">",time());
    }
}
