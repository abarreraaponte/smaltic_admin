<?php

namespace App\Models;

use App\Models\BaseModel;

class JobLine extends BaseModel
{
    public function canBeDeleted()
    {
    	return true;
    }

    public function job()
    {
    	return $this->belongsTo('App\Models\Job');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function artist()
    {
        return $this->belongsTo('App\Models\Artist');
    }
}
