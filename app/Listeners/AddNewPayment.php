<?php

namespace App\Listeners;

use App\Events\ProcessPurchase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddNewPayment
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
        $charge = $event->billable->charge(
            $event->payment,
            $event->customer
        );

        if (empty($charge->error)) {
            return [
                'status' => 'success',
                'title' => "Pago correctamente recibido",
                'message' => "Pago correctamente recibido",
                'data' => $charge
            ];
        } else {
            return [
                'status' => 'error',
                'title' => "Error al procesar pago",
                'message' => $charge->error,
                'data' => $charge
            ];
        }
    }
}
