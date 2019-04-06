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

    public function expense()
    {
        return $this->belongsTo('App\Models\Expense');
    }

    public function canBeDeleted()
    {
        return true;
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function reward()
    {
        return $this->hasOne('App\Models\Reward');
    }

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }

    public function description()
    {
        if($this->job != null)
        {
            return 'Pago por trabajo';
        }
        elseif ($this->expense != null)
        {
            return 'Gasto';
        }
        elseif ($this->job === null and $this->expense === null)
        {
            return 'Transferencia';
        }
    }
}
