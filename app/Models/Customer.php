<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Discount;

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

    public function rewards()
    {
        return $this->hasMany('App\Models\Reward');
    }

    public function discounts()
    {
        return $this->hasMany('App\Models\Discount');
    }

    public function canBeDeleted()
    {
        $jb = $this->jobs->count();
        $p = $this->payments->count();

        if($jb + $p >= 1)
        {
            return false;
        }

        else
        {
            return true;
        }

    }

    public function getAvailableDiscounts()
    {
         return Discount::where('customer_id', $this->id)->unapplied()->get();
    }

    public function getAvailableDiscountAmount()
    {
        $discounts = Discount::where('customer_id', $this->id)->unapplied()->get();

        return $discounts->pluck('amount')->sum();
    }
}
