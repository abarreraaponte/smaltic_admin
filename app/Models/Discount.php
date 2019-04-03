<?php

namespace App\Models;

use App\Models\BaseModel;

class Discount extends BaseModel
{
    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer');
    }

    public function job()
    {
    return $this->belongsTo('App\Models\Job');
    }

    public function canBeDeleted()
    {
        return true;
    }

    /**
     * @param $query
     * @return mixed
     * Defines the Local Scope only query active records.
     */
    public function scopeApplied($query)
    {
        return $query->whereNotNull('job_id');
    }

    /**
     * @param $query
     * @return mixed
     * Defines a Scope to only query inactive records.
     */
    public function scopeUnapplied($query)
    {
        return $query->whereNull('job_id');
    }
}
