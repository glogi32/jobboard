<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory,SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_cv()
    {
        return $this->belongsTo(User_cv::class,"user_cv_id")->withTrashed();
    }

    public function job()
    {
        return $this->belongsTo(Job::class)->withTrashed();
    }
}
