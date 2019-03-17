<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sparepart;

class SparepartTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Sparepart $sparepart
     */
    public function transform(Sparepart $sparepart)
    {
        return [
            'id_sparepart' => $sparepart->id_sparepart,
            'sparepart_name' => $sparepart->sparepart_name,
            'merk' => $sparepart->merk,
            'stock' => $sparepart->stock,
            'min_stock' => $sparepart->min_stock,
            'purchase_price' => $sparepart->purchase_price,
            'sell_price' => $sparepart->sell_price,
            'placement' => $sparepart->placement,
            'image' => $sparepart->image,
            'sparepart_type_name' => $sparepart->sparepart_types->sparepart_type_name,
        ];
    }
}