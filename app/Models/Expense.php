<?php

namespace App\Models;

use App\Models\BaseModel;

class Expense extends BaseModel
{
    public function expense_payments()
    {
    	return $this->hasMany('App\Models\ExpensePayment');
    }

    public function expense_lines()
    {
        return $this->hasMany('App\Models\ExpenseLine');
    }

    public function canBeDeleted()
    {
        $ep = $this->expense_payments->count();

        if($ep >= 1)
        {
            return false;
        }

        else
        {
            return true;
        }

    }

    public function getAmount()
    {
        return $this->expense_lines->pluck('amount')->sum();
    }

    public function getPaidAmount()
    {
        return $this->expense_payments->pluck('amount')->sum();
    }

    public function getPendingAmount()
    {
        return $this->getAmount() - $this->getPaidAmount();
    }
}
