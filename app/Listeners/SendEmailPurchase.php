<?php

namespace App\Listeners;

use App\Events\ProcessPurchase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailPurchase
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
     * @param  ProcessPurchase  $event
     * @return void
     */
    public function handle(ProcessPurchase $event)
    {
        //
    }
}
