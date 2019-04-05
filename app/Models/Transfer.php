<?php

namespace App\Models;

use App\Models\BaseModel;

class Transfer extends BaseModel
{
    public function canBeDeleted()
    {
        return false;
    }

    public function origin_account()
    {
        return $this->belongsTo(Account::class, 'origin_account_id');
    }

    public function end_account()
    {
        return $this->belongsTo(Account::class, 'end_account_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function expense_payent()
    {
        return $this->hasMany(ExpensePayment::class);
    }
}
