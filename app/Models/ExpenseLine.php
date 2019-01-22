<?php

namespace App\Models;

use App\Models\BaseModel;

class ExpenseLine extends BaseModel
{
    public function expense()
    {
    	return $this->belongsTo('App\Models\Expense');
    }

    public function canBeDeleted()
    {
        $ep = $this->expense->expense_payments->count();

        if($ep >= 1)
        {
            return false;
        }

        else
        {
            return true;    
        }
        
    }
}
