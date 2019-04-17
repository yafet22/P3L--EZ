<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Detail_service;

class Detail_serviceTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Detail_service $detail_service
     */
    public function transform(Detail_service $detail_service)
    {
        return [
            'id_detail_service' => $detail_service->id_detail_service,
            'detail_service_amount' => $detail_service->detail_service_amount,
            'detail_service_price' => $detail_service->detail_service_price,
            'detail_service_subtotal' => $detail_service->detail_service_subtotal,
            'id_transaction' => $detail_service->id_transaction,
            'id_service' => $detail_service->id_service,
            'service_name' => $detail_service->services->service_name,
            'id_mechanic_onduty' => $detail_service->id_mechanic_onduty,
            'mechanic_name' => $detail_service->mechanic_onduties->employees->name,
            'license_number' => $detail_service->mechanic_onduties->motorcycles->license_number,
        ];
    }
}