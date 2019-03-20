<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sales;

class SalesTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Sales $sales
     */
    public function transform(Sales $sales)
    {
        return [
            'id_sales' => $sales->id_sales,
            'sales_name' => $sales->sales_name,
            'id_supplier' => $sales->id_supplier,
            'supplier_name' => $sales->suppliers->supplier_name,
            'sales_phone_number' => $sales->sales_phone_number,
        ];
    }
}