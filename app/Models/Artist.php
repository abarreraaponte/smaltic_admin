<?php

namespace App\Models;

use App\Models\BaseModel;

class Artist extends BaseModel
{
    public function job_lines()
    {
    	return $this->hasMany('App\Models\Job');
    }

    public function customers()
    {
    	return $this->hasMany('App\Models\Customer');
    }

    public function canBeDeleted()
    {
        $jl = $this->job_lines->count();
        $c = $this->customers->count();

        if($jl + $c >= 1)
        {
            return false;
        }

        else
        {
            return true;
        }

    }
}
