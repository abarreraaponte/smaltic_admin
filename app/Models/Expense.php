<?php

namespace App\Models;

use App\Models\BaseModel;

class Expense extends BaseModel
{
    public function expense_payments()
    {
    	return $this->hasMany('App\Models\ExpensePayment');
    }
}
