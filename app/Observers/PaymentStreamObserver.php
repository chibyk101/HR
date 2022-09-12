<?php

namespace App\Observers;

use App\Models\PaymentStream;

class PaymentStreamObserver
{
    /**
     * Handle the PaymentStream "created" event.
     *
     * @param  \App\Models\PaymentStream  $paymentStream
     * @return void
     */
    public function created(PaymentStream $paymentStream)
    {
        //
    }

    /**
     * Handle the PaymentStream "updated" event.
     *
     * @param  \App\Models\PaymentStream  $paymentStream
     * @return void
     */
    public function updated(PaymentStream $paymentStream)
    {
        
    }

    /**
     * Handle the PaymentStream "deleted" event.
     *
     * @param  \App\Models\PaymentStream  $paymentStream
     * @return void
     */
    public function deleted(PaymentStream $paymentStream)
    {
        //
    }

    /**
     * Handle the PaymentStream "restored" event.
     *
     * @param  \App\Models\PaymentStream  $paymentStream
     * @return void
     */
    public function restored(PaymentStream $paymentStream)
    {
        //
    }

    /**
     * Handle the PaymentStream "force deleted" event.
     *
     * @param  \App\Models\PaymentStream  $paymentStream
     * @return void
     */
    public function forceDeleted(PaymentStream $paymentStream)
    {
        //
    }
}
