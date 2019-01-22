<?php

namespace App\Models;

use App\Models\BaseModel;

class Job extends BaseModel
{
    
    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer');
    }

    public function payments()
    {
    	return $this->hasMany('App\Models\Payment');
    }

    public function job_lines()
    {
        return $this->hasMany('App\Models\JobLine');
    }

    public function canBeDeleted()
    {
        $p = $this->payments->count();
        $jl = $this->job_lines->count();

        if($p + $jl >= 1)
        {
            return false;
        }

        else
        {
            return true;
        }

    }
}
