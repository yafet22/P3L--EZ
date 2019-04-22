<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transaction;

class TransactionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'service',
        'sparepart',
        'employee'
    ];
    /**
     * Transform Barang.
     *
     * @param Transaction $transaction
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id_transaction' => $transaction->id_transaction,
            'transaction_status' => $transaction->transaction_status,
            'transaction_date' => $transaction->transaction_date,
            'transaction_paid' => $transaction->transaction_paid,
            'transaction_type' => $transaction->transaction_type,
            'transaction_discount' => $transaction->transaction_discount,
            'transaction_total' => $transaction->transaction_total,
            'id_customer' => $transaction->id_customer,
            'customer_name' => $transaction->customers->customer_name,
        ];
    }

    public function includeService(Transaction $transaction)
    {
        return $this->collection($transaction->detail_services, new Detail_serviceTransformer);
    }

    public function includeSparepart(Transaction $transaction)
    {
        return $this->collection($transaction->detail_spareparts, new Detail_sparepartTransformer);
    }

    public function includeEmployee(Transaction $transaction)
    {
        return $this->collection($transaction->employees, new EmployeeTransformer);
    }
}