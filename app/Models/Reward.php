<?php

namespace App\Models;

use App\Models\BaseModel;

class Reward extends BaseModel
{
    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer');
    }

    public function job()
    {
    	return $this->belongsTo('App\Models\Job');
    }

    public function payment()
    {
        return $this->belongsTo('App\Models\Payment');
    }
}
