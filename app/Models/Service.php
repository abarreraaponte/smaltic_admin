<?php

namespace App\Models;

use App\Models\BaseModel;

class Service extends BaseModel
{
    public function jobs()
    {
    	return $this->hasMany('App\Models\Job');
    }

    public function canBeDeleted()
    {
    	$jl = $this->job_lines->count();

    	if($jl >= 1)
    	{
    		return false;
    	}

    	else
    	{
    		return true;
    	}

    }
}
