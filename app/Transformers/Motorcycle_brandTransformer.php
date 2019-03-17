<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Motorcycle_Brand;

class Motorcycle_brandTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Motorcycle_Brand $Motorcycle_Brand
     */
    public function transform(Motorcycle_Brand $motorcycle_brand)
    {
        return [
            'id_motorcycle_brand' => $motorcycle_brand->id_motorcycle_brand,
            'motorcycle_brand_name' => $motorcycle_brand->motorcycle_brand_name,
        ];
    }
}