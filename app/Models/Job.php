<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function technologies()
    {
        return $this->belongsToMany(Technology::class,"job_technologies");
    }

    public function company()
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function savedJobs(){
        return $this->belongsToMany(User::class,"saved_jobs");
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
