<?php

namespace App\Models;

use App\Models\BaseModel;

class Account extends BaseModel
{
    public function payments()
    {
    	return $this->hasMany('App\Models\Payment');
    }

    public function expensePayment()
    {
    	return $this->hasMany('App\Models\ExpensePayment');
    }

    
}
