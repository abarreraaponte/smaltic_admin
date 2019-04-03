<?php

namespace App\Listeners;

use App\Events\PaymentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Reward;

class AddPaymentReward
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentCreated  $event
     * @return void
     */
    public function handle(PaymentCreated $event)
    {
        if($event->payment->account->is_reward === 1)
        {
            $reward = new Reward;
            $reward->job_id = $event->payment->job_id;
            $reward->customer_id = $event->payment->customer->id;
            $reward->payment_id = $event->payment->id;
            $reward->value = $event->payment->amount * -1;
            $reward->description = 'Uso de Puntos';
            $reward->save();
        }
    }
}
