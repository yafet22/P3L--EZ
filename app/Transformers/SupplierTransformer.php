<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Supplier;

class SupplierTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Supplier $supplier
     */
    public function transform(Supplier $supplier)
    {
        return [
            'id_supplier' => $supplier->id_supplier,
            'supplier_name' => $supplier->supplier_name,
            'supplier_address' => $supplier->supplier_address,
            'supplier_phone_number' => $supplier->supplier_phone_number,
        ];
    }
}