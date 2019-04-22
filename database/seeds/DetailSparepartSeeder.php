<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DetailSparepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_spareparts')->insert([
            [
                'detail_sparepart_amount'      => 1,
                'detail_sparepart_price' => 35000,
                'detail_sparepart_subtotal' => 35000,
                'id_transaction' => 'SP-031019-2',
                'id_sparepart' => 'BA113',
                'id_employee' => 6,
                'id_motorcycle' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'detail_sparepart_amount'      => 1,
                'detail_sparepart_price' => 30000,
                'detail_sparepart_subtotal' => 30000,
                'id_transaction' => 'SP-031019-2',
                'id_sparepart' => 'FY155',
                'id_employee' => 6,
                'id_motorcycle' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'detail_sparepart_amount'      => 1,
                'detail_sparepart_price' => 120000,
                'detail_sparepart_subtotal' => 120000,
                'id_transaction' => 'SS-031019-3',
                'id_sparepart' => 'BA112',
                'id_employee' => 7,
                'id_motorcycle' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
