<?php

namespace App\Conekta;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use App\Conekta\Payment;

trait Billable {

    /**
     * Get the name that should be shown on the entity's invoices.
     *
     * @return string
     */
    public function getBillableDescription()
    {
        return $this->name;
    }

    /**
     * Get the total that should be shown on the entity's invoices.
     *
     * @return string
     */
    public function getBillableTotal()
    {
        return $this->price;
    }

    /**
     * Write the entity to persistent storage.
     *
     * @return void
     */
    public function saveBillableInstance()
    {
        $this->save();
    }

    /**
     * Make a "one off" charge on the customer for the given amount.
     *
     * @param int   $amount
     * @param array $options
     *
     * @return bool|mixed
     */
    public function charge($payment, $customer)
    {
        $oPayment = new Payment(
            $payment->method,
            $this->getBillableDescription(),
            $this->getBillableTotal()
        );

         $oPayment->setCustomer(
            $customer->getEmail(),
            $customer->getName(),
            $customer->getConektaID()
        );

        if($payment->method == 'card') {
            $oPayment->setTokenCard($payment->conektaTokenId);
        }

        if ($oPayment->pay()) {
            $customer->setConektaID($oPayment->customer->id);
            $customer->saveCustomer();
        }

        return $oPayment;
    }

    /**
     * Get the Stripe supported currency used by the entity.
     *
     * @return string
     */
    public function getCurrency()
    {
        return 'mxn';
    }

    /**
     * Get the locale for the currency used by the entity.
     *
     * @return string
     */
    public function getCurrencyLocale()
    {
        return 'es_MX';
    }

    /**
     * Format the given currency for display, without the currency symbol.
     *
     * @param int $amount
     *
     * @return mixed
     */
    public function formatCurrency($amount)
    {
        return number_format($amount / 100, 2);
    }

    /**
     * Add the currency symbol to a given amount.
     *
     * @param string $amount
     *
     * @return string
     */
    public function addCurrencySymbol($amount)
    {
        return '$' . $amount;
    }
}