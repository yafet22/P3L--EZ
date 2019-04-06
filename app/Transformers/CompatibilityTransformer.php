<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Motorcycle_Type;

class CompatibilityTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Motorcycle_Type $motorcycle
     */
    public function transform(Motorcycle_Type $motorcycle)
    {
        return [
            'id_motorcycle_type' => $motorcycle->id_motorcycle_type,
            'motorcycle_type_name' => $motorcycle->motorcycle_type_name,
            'id_motorcycle_brand' => $motorcycle->id_motorcycle_brand,
            'motorcycle_brand' => $motorcycle->motorcycle_brands->motorcycle_brand_name,
        ];
    }
}