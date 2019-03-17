<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DetailServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_services')->insert([
            [
                'detail_service_amount'      => 1,
                'detail_service_price' => 35000,
                'detail_service_subtotal' => 35000,
                'id_transaction' => 'SS-031019-3',
                'id_service' => 3,
                'id_mechanic_onduty' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'detail_service_amount'      => 1,
                'detail_service_price' => 30000,
                'detail_service_subtotal' => 30000,
                'id_transaction' => 'SV-031019-1',
                'id_service' => 1,
                'id_mechanic_onduty' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'detail_service_amount'      => 1,
                'detail_service_price' => 30000,
                'detail_service_subtotal' => 30000,
                'id_transaction' => 'SV-031019-4',
                'id_service' => 1,
                'id_mechanic_onduty' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
