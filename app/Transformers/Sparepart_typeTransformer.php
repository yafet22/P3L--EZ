<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sparepart_type;

class Sparepart_typeTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Sparepart_type $sparepart_type
     */
    public function transform(Sparepart_type $sparepart_type)
    {
        return [
            'id_sparepart_type' => $sparepart_type->id_sparepart_type,
            'sparepart_type_name' => $sparepart_type->sparepart_type_name,
        ];
    }
}