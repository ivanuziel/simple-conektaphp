<?php

namespace App\Conekta;

trait Customer {

    /**
     * Get the name that should be shown on the entity's invoices.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the email that should be shown on the entity's invoices.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the conekta id that should be shown on the entity's invoices.
     *
     * @return string
     */

    public function getConektaID()
    {
        return $this->conekta_id;
    }

    public function setConektaID($conekta_id)
    {
        return $this->conekta_id = $conekta_id;
    }

    /**
     * Write the entity to persistent storage.
     *
     * @return void
     */
    public function saveCustomer()
    {
        $this->save();
    }
}