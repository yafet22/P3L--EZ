<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Detail_service;

class CheckStatusTransformer extends TransformerAbstract
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
            'id_employee' => $detail_service->id_employee,
            'mechanic_name' => $detail_service->mechanics->name,
            'license_number' => $detail_service->motorcycles->license_number,
            'id_motorcycle' => $detail_service->motorcycles->id_motorcycle,
            'status' => $detail_service->transactions->transaction_status,
            'payment' => $detail_service->transactions->transaction_paid,
            'date' => $detail_service->transactions->transaction_date,
            'type' => $detail_service->transactions->transaction_type,
        ];
    }
}