<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'id_transaction' => 'SV-031019-1',
                'transaction_status'      => 'finish',
                'transaction_date' => Carbon::now(),
                'transaction_paid' => 'paid',
                'transaction_type' => 'Service',
                'transaction_discount' => 0,
                'transaction_total' => 30000,
                'id_customer' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_transaction' => 'SP-031019-2',
                'transaction_status'      => 'finish',
                'transaction_date' => Carbon::now(),
                'transaction_paid' => 'paid',
                'transaction_type' => 'Sparepart',
                'transaction_discount' => 10000,
                'transaction_total' => 55000,
                'id_customer' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_transaction' => 'SS-031019-3',
                'transaction_status'      => 'on progress',
                'transaction_date' => Carbon::now(),
                'transaction_paid' => 'unpaid',
                'transaction_type' => 'Service And Sparepart',
                'transaction_discount' => 0,
                'transaction_total' => 155000,
                'id_customer' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_transaction' => 'SV-031019-4',
                'transaction_status'      => 'on progress',
                'transaction_date' => Carbon::now(),
                'transaction_paid' => 'unpaid',
                'transaction_type' => 'Service',
                'transaction_discount' => 0,
                'transaction_total' => 30000,
                'id_customer' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
