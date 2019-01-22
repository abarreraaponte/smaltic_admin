<?php

namespace App\Models;

use App\Models\BaseModel;

class Service extends BaseModel
{
    public function job_lines()
    {
    	return $this->hasMany('App\Models\JobLine');
    }

    public function canBeDeleted()
    {
    	$jl = $this->job_lines->count();

    	if($jl + >= 1)
    	{
    		return false;
    	}

    	else
    	{
    		return true;
    	}

    }
}
