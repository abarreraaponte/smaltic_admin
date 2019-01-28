<?php

namespace App\Models;

use App\Models\BaseModel;

class PaymentMethod extends BaseModel
{
    public function payments()
    {
    	return $this->hasMany('App\Models\Payment');
    }

    public function expense_payments()
    {
    	return $this->hasMany('App\Models\ExpensePayment');
    }

    public function canBeDeleted()
    {
        $p = $this->payments->count();
    	$ep = $this->expense_payments->count();

    	if($p + $ep >= 1 or $this->is_reward === 1)
    	{
    		return false;
    	}

    	else
    	{
    		return true;
    	}
	}
}
