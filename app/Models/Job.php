<?php

namespace App\Models;

use App\Models\BaseModel;

class Job extends BaseModel
{

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer');
    }

    public function payments()
    {
    	return $this->hasMany('App\Models\Payment');
    }

    public function job_lines()
    {
        return $this->hasMany('App\Models\JobLine');
    }

    public function canBeDeleted()
    {
        $p = $this->payments->count();

        if($p >= 1)
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
        $line_amount = $this->job_lines->pluck('amount')->sum();
        $discount_amount = $this->discounts->pluck('amount')->sum();

        return $line_amount - $discount_amount;
    }

    public function getDiscountAmount()
    {
        return $this->discounts->pluck('amount')->sum();
    }

    public function getPaidAmount()
    {
        return $this->payments->pluck('amount')->sum();
    }

    public function getPendingAmount()
    {
        return $this->getAmount() - $this->getPaidAmount();
    }

    public function reward()
    {
        return $this->hasOne('App\Models\Reward');
    }

    public function discounts()
    {
        return $this->hasMany('App\Models\Discount');
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
