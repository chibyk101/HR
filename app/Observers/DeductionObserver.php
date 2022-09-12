<?php

namespace App\Observers;

use App\Models\Deduction;
use App\Services\PaymentService;

class DeductionObserver
{
    /**
     * Handle the Deduction "created" event.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return void
     */
    public function created(Deduction $deduction)
    {
        //
    }

    /**
     * Handle the Deduction "updated" event.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return void
     */
    public function updated(Deduction $deduction)
    {
        //
    }

    /**
     * Handle the Deduction "deleted" event.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return void
     */
    public function deleted(Deduction $deduction)
    {
      (new PaymentService)->regeneratePayslip($deduction->user);
    }

    /**
     * Handle the Deduction "restored" event.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return void
     */
    public function restored(Deduction $deduction)
    {
        //
    }

    /**
     * Handle the Deduction "force deleted" event.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return void
     */
    public function forceDeleted(Deduction $deduction)
    {
        //
    }

    public function saved(Deduction $deduction)
    {
      (new PaymentService)->regeneratePayslip($deduction->user);
    }
}
