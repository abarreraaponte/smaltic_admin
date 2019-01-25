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

    public function getAmount()
    {
        return $this->job_lines->pluck('amount')->sum();
    }

    public function getPaidAmount()
    {
        return $this->payments->pluck('amount')->sum();
    }

    public function getPendingAmount()
    {
        return $this->getAmount() - $this->getPaidAmount();
    }
}
