<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Service;

class ServiceTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Service $service
     */
    public function transform(Service $service)
    {
        return [
            'id_service' => $service->id_service,
            'service_name' => $service->service_name,
            'price' => $service->price,
        ];
    }
}