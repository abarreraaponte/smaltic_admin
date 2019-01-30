<?php

namespace App\Models;

use App\Models\BaseModel;

class Artist extends BaseModel
{
    public function jobs()
    {
    	return $this->hasMany('App\Models\Job');
    }

    public function customers()
    {
    	return $this->hasMany('App\Models\Customer');
    }

    public function canBeDeleted()
    {
        $jobs = $this->jobs->count();
        $c = $this->customers->count();

        if($jobs + $c >= 1)
        {
            return false;
        }

        else
        {
            return true;
        }

    }
}
