<?php

namespace App\Models;

use App\Models\BaseModel;

class ExpenseCategory extends BaseModel
{
    public function expense_lines()
    {
    	return $this->hasMany('App\Models\ExpenseLine');
    }

    public function canBeDeleted()
    {
        $el = $this->expense_lines->count();

        if($el >= 1)
        {
            return false;
        }

        else
        {
            return true;
        }

    }
}
