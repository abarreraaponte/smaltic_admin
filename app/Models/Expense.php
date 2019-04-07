<?php

namespace App\Models;

use App\Models\BaseModel;

class Expense extends BaseModel
{
    public function payments()
    {
    	return $this->hasMany('App\Models\Payment');
    }

    public function expense_lines()
    {
        return $this->hasMany('App\Models\ExpenseLine');
    }

    public function canBeDeleted()
    {
        $ep = $this->payments->count();

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
        return -1 * $this->payments->pluck('amount')->sum();
    }

    public function getPendingAmount()
    {
        return $this->getAmount() - $this->getPaidAmount();
    }

    /**
    *
    * Add List of roles to be selected
    **/
    public static function payment_statuses()
    {
        return collect([
            [
                'name' => 'pending_payment',
                'label' => __('Pendiente de Pago'),
            ],
            [
                'name' => 'partial_payment',
                'label' => __('Pago Parcial'),
            ],
            [
                'name' => 'paid',
                'label' => __('Pagado'),
            ],
        ]);
    }
    
    /**
    *
    * Gets the role label
    **/
    public function getPaymentStatusLabel()
    {
        return $this->payment_statuses()->where('name', $this->payment_status)->pluck('label')->first();
    }


    // Update Job Payment Status
    public function updatePaymentStatus()
    {
        if($this->getPendingAmount() === 0)
        {
            $this->payment_status = 'paid';
            $this->save();
        }

        elseif($this->getPaidAmount() === 0)
        {
            $this->payment_status = 'pending_payment';
            $this->save();
        }

        else
        {
            $this->payment_status = 'partial_payment';
            $this->save();
        }
    }
}
