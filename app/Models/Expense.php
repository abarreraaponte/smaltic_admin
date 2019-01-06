<?php

namespace App\Models;

use App\Models\BaseModel;

class Expense extends BaseModel
{
    public function expense_payments()
    {
    	return $this->hasMany('App\Models\ExpensePayment');
    }

    public function canBeDeleted()
    {
        $ep = $this->expense_payments->count();

        if($jb >= 1)
        {
            return false;
        }

        else
        {
            return true;
        }

    }
}
