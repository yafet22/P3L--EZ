<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Motorcycle;

class MotorcycleTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Motorcycle $Motorcycle
     */
    public function transform(Motorcycle $motorcycle)
    {
        return [
            'id_motorcycle' => $motorcycle->id_motorcycle,
            'license_number' => $motorcycle->license_number,
            'motorcycle_type' => $motorcycle->motorcycle_types->motorcycle_type_name,
            'motorcycle_brand' => $motorcycle->motorcycle_types->motorcycle_brands->motorcycle_brand_name,
            'id_motorcycle_type' => $motorcycle->id_motorcycle_type,
            'id_motorcycle_brand' => $motorcycle->motorcycle_types->id_motorcycle_brand,
            'id_customer' => $motorcycle->id_customer,
            'customer' => $motorcycle->customers->customer_name,
            'edit' => false,
        ];
    }
}