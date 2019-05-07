<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Detail_sparepart;

class Detail_sparepartTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Detail_sparepart $detail_sparepart
     */
    public function transform(Detail_sparepart $detail_sparepart)
    {
        return [
            'id_detail_sparepart' => $detail_sparepart->id_detail_sparepart,
            'detail_sparepart_amount' => $detail_sparepart->detail_sparepart_amount,
            'detail_sparepart_price' => $detail_sparepart->detail_sparepart_price,
            'detail_sparepart_subtotal' => $detail_sparepart->detail_sparepart_subtotal,
            'id_transaction' => $detail_sparepart->id_transaction,
            'id_sparepart' => $detail_sparepart->id_sparepart,
            'sparepart_type' => $detail_sparepart->spareparts->sparepart_types->sparepart_type_name,
            'sparepart_name' => $detail_sparepart->spareparts->sparepart_name,
            'merk' => $detail_sparepart->spareparts->merk,
            'id_mechanic' => $detail_sparepart->id_employee,
            'mechanic_name' => optional($detail_sparepart->mechanics)->name,
            'id_motorcycle' => optional($detail_sparepart->motorcycles)->id_motorcycle,
            'license_number' => optional($detail_sparepart->motorcycles)->license_number,
        ];
    }
}