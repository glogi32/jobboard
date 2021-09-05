<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    public function job()
    {
        return $this->belongsToMany(Job::class,"job_technologies");
    }
}
