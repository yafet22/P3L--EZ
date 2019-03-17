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
            'customer' => $motorcycle->customers->customer_name,
        ];
    }
}