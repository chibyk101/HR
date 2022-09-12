<?php

namespace App\Observers;

use App\Models\Overtime;
use App\Services\PaymentService;

class OvertimeObserver
{
    /**
     * Handle the Overtime "saving" event.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return void
     */
    public function saving(Overtime $overtime)
    {
        $overtime->total = $overtime->number_of_days * $overtime->hours * $overtime->rate;
    }

    /**
     * Handle the Overtime "updated" event.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return void
     */
    public function updated(Overtime $overtime)
    {
        //
    }

    /**
     * Handle the Overtime "deleted" event.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return void
     */
    public function deleted(Overtime $overtime)
    {
      (new PaymentService)->regeneratePayslip($overtime->user);
        
    }

    /**
     * Handle the Overtime "restored" event.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return void
     */
    public function restored(Overtime $overtime)
    {
        //
    }

    /**
     * Handle the Overtime "force deleted" event.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return void
     */
    public function forceDeleted(Overtime $overtime)
    {
        //
    }

    public function saved(Overtime $overtime)
    {
      (new PaymentService)->regeneratePayslip($overtime->user);
    }
}
