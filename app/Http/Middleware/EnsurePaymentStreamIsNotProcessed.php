<?php

namespace App\Http\Middleware;

use App\Models\PaymentStream;
use Closure;
use Illuminate\Http\Request;

class EnsurePaymentStreamIsNotProcessed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      /**
       * @var PaymentStream $paymentStream
       */
      if($paymentStream = $request->route('paymentStream')){
        abort_if($paymentStream->getRawOriginal('processed_at'),403,"Payment Stream already processed");
      }
        return $next($request);
    }
}
