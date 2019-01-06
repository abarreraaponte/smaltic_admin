<?php

namespace App\Models;

use App\Models\BaseModel;

class Payment extends BaseModel
{
    public function account()
    {
    	return $this->belongsTo('App\Models\Account');
    }

    public function payment_method()
    {
    	return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function job()
    {
    	return $this->belongsTo('App\Models\Job');
    }

    public function canBeDeleted()
    {
        return true;
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
