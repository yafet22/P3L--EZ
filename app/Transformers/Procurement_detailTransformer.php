<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Procurement_detail;

class Procurement_detailTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Procurement_detail $procurement_detail
     */
    public function transform(Procurement_detail $procurement_detail)
    {
        return [
            'id_procurement_detail' => $procurement_detail->id_procurement_detail,
            'price' => $procurement_detail->price,
            'amount' => $procurement_detail->amount,
            'subtotal' => $procurement_detail->subtotal,
            'id_procurement' => $procurement_detail->id_procurement,
            'id_sparepart' => $procurement_detail->id_sparepart
        ];
    }

}