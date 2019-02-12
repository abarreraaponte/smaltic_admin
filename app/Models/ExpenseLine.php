<?php

namespace App\Models;

use App\Models\BaseModel;

class ExpenseLine extends BaseModel
{
    public function expense()
    {
    	return $this->belongsTo('App\Models\Expense');
    }

    public function expense_category()
    {
    	return $this->belongsTo('App\Models\ExpenseCategory');
    }

    public function canBeDeleted()
    {
        return true;
    }
}
