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

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
}
