<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Procurement;

class ProcurementTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'detail'
    ];

    /**
     * Transform Barang.
     *
     * @param Procurement $procurement
     */
    public function transform(Procurement $procurement)
    {
        return [
            'id_procurement' => $procurement->id_procurement,
            'date' => $procurement->date,
            'procurement_status' => $procurement->procurement_status,
            'id_sales' => $procurement->id_sales,
            'id_supplier' => $procurement->sales->suppliers->id_supplier,
            'sales' => $procurement->sales->sales_name,
            'supplier' => $procurement->sales->suppliers->supplier_name
        ];
    }

    public function includeDetail(Procurement $procurement)
    {
        return $this->collection($procurement->procurementdetails, new Procurement_detailTransformer);
    }
}