<?php

namespace App\Listeners;

use App\Events\PaymentDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Reward;

class DeletePaymentReward
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
     * @param  PaymentDeleted  $event
     * @return void
     */
    public function handle(PaymentDeleted $event)
    {
        if($event->payment->reward != null)
        {
            $reward = Reward::where('payment_id', $event->payment->id)->first();
            $reward->delete();
        }
    }
}
