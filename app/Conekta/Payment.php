<?php
namespace App\Conekta;

use App\Conekta\Billable;

class Payment {
    private $privateApiKey;
    private $apiVersion = "2.0.0";

    public function __construct($method, $description, $total)
    {
        $this->privateApiKey = config('conekta.secret_key');

        $this->method = $method;
        $this->description = $description;
        $this->total = $total;

        $this->error = null;
    }

    public function setTokenCard($card_token)
    {
        $this->card_token = $card_token;
    }

    public function setCustomer($customer_email, $customer_name, $customer_id = null)
    {
        $this->customer_email = $customer_email;
        $this->customer_name = $customer_name;
        $this->customer_id = $customer_id;
    }

    public function pay()
    {
        \Conekta\Conekta::setApiKey($this->privateApiKey);
        \Conekta\Conekta::setApiVersion($this->apiVersion);

        if (!$this->validate()) {
            return false;
        }

        
        $this->customer = $this->customer_id ? $this->getCustomer($this->customer_id) : $this->createCustomer();

        if (!$this->createOrder()) {
            return false;
        }

        return true;
    }

    public function validate()
    {
        if (($this->method == 'card' && empty($this->card_token))) {
            $this->error = "No se encontró el token de la tarjeta";
            return false;
        }
        if (empty($this->total)) {
            $this->error = "Faltan datos para el pago";
            return false;
        }

        return true;
    }

    public function createCustomer()
    {
        $data = [ 'name'  => $this->customer_name, 'email' => $this->customer_email ];
        if($this->method == 'card'){
            $data['payment_sources'] = [
                [
                    'token_id' => $this->card_token,
                    'type' => "card"
                ]
            ];
        }

        return \Conekta\Customer::create($data);
    }

    public function getCustomer($customer_id)
    {
        if (!empty($customer_id) && $customer_id != null) {
            try {
                $customer = \Conekta\Customer::find($customer_id);
                return $customer;
            } catch (\Conekta\Handler $err) {
                $this->error = $err->getMessage();
                return false;
            }
        } else {
            return $this->createCustomer();
        }
    }

    public function createOrder()
    {
        $dataPayment = [];
        if($this->method == 'card'){
            $dataPayment = [ "type" => 'default' ];
        }
        else if($this->method == 'oxxo_cash'){
            $dataPayment = [
                "type" => 'oxxo_cash',
                "expires_at" => (new \DateTime())->add(new \DateInterval('P30D'))->getTimestamp() //Thirty Days From Now
            ];
        }

        try {
            $this->order = \Conekta\Order::create(array(
                // PARAMS BY CONEKTA ACCOUNT
                'shipping_lines' => array(
                    array(
                        "amount" => 0,
                        "carrier" => "FEDEX"
                    )
                ),
                'shipping_contact' => array(
                    "address" => [
                        "street1" => "Calle",
                        "postal_code" => "97000",
                        "country" => "MX"
                  ]
                ),
                //

                'amount' => $this->total,
                'currency' => 'MXN',
                'customer_info' => array(
                  'customer_id' => $this->customer->id
                ),
                'line_items' => array(
                  array(
                    'name' => $this->description,
                    'unit_price' => $this->getUnitPrice(),
                    'quantity' => 1
                  )
                ),
                'charges' => array(
                  array(
                    'payment_method' => $dataPayment
                  )
                )
            ));
        } catch (\Conekta\ProcessingError $err) {
            $this->error = $err->getMessage();
            return false;
        } catch (\Conekta\ParameterValidationError $err) {
            $this->error = $err->getMessage();
            return false;
        } catch (\Conekta\Handler $err) {
            $this->error = $err->getMessage();
            return false;
        }

        return true;
    }

    public function getUnitPrice()
    {
        //return intval($this->total * 100 * 1.16);
        return $this->total * 100;
    }

    public function getQty()
    {
        return empty($this->qty) ? $this->qty : 1;
    }
}