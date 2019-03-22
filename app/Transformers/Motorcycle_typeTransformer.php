<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Motorcycle_Type;

class Motorcycle_typeTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Motorcycle_type $Motorcycle_type
     */
    public function transform(Motorcycle_Type $motorcycle_type)
    {
        return [
            'id_motorcycle_type' => $motorcycle_type->id_motorcycle_type,
            'motorcycle_type_name' => $motorcycle_type->motorcycle_type_name,
            'id_motorcycle_brand' => $motorcycle_type->id_motorcycle_brand,
            'motorcycle_brand' => $motorcycle_type->motorcycle_brands->motorcycle_brand_name,
        ];
    }
}