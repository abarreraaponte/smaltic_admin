<?php

namespace App\Models;

use App\Models\BaseModel;

class ExpensePayment extends BaseModel
{
    public function account()
    {
    	return $this->belongsTo('App\Models\Account');
    }

    public function payment_method()
    {
    	return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function expense()
    {
    	return $this->belongsTo('App\Models\Expense');
    }
}
