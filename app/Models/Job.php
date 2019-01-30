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

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function artist()
    {
        return $this->belongsTo('App\Models\Artist');
    }

    public function canBeDeleted()
    {
        $p = $this->payments->count();

        if($p >= 1)
        {
            return false;
        }

        else
        {
            return true;
        }

    }


    public function getPaidAmount()
    {
        return $this->payments->pluck('amount')->sum();
    }

    public function getPendingAmount()
    {
        return $this->amount - $this->getPaidAmount();
    }
}
