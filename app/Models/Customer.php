<?php

namespace App\Models;

use App\Models\BaseModel;

class Customer extends BaseModel
{
    public function artist()
    {
    	return $this->belongsTo('App\Models\Artist');
    }

    public function jobs()
    {
    	return $this->hasMany('App\Models\Job');
    }

    public function payments()
    {
    	return $this->hasMany('App\Models\Payment');
    }

    public function source()
    {
    	return $this->belongsTo('App\Models\Source');
    }
}
