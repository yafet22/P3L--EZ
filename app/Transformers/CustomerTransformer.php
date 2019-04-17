<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Customer;

class CustomerTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Customer $customer
     */
    public function transform(Customer $customer)
    {
        return [
            'id_customer' => $customer->id_customer,
            'customer_name' => $customer->customer_name,
            'customer_address' => $customer->customer_address,
            'customer_phone_number' => $customer->customer_phone_number,
        ];
    }
}