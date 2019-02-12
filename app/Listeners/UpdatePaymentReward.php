<?php

namespace App\Listeners;

use App\Events\PaymentUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Reward;

class UpdatePaymentReward
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
     * @param  PaymentUpdated  $event
     * @return void
     */
    public function handle(PaymentUpdated $event)
    {
        if($event->payment->reward != null)
        {
            $reward = Reward::where('payment_id', $event->payment->id)->first();
            $reward->value = $event->payment->amount * -1;
            $reward->save();
        }
    }
}
