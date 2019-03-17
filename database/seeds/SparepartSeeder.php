<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SparepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('spareparts')->insert([
            [
                'id_sparepart' => 'BA112',
                'sparepart_name'      => 'Tromol Depan',
                'merk' => 'Astra',
                'stock' => 10,
                'min_stock' => 2,
                'placement' => 'DPN-KACA-01',
                'image' => '',
                'id_sparepart_type' => 1,
                'purchase_price' => '100000',
                'sell_price'      => '120000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_sparepart' => 'BA113',
                'sparepart_name'      => 'Busi',
                'merk' => 'Mantab',
                'stock' => 30,
                'min_stock' => 6,
                'placement' => 'DPN-KAYU-01',
                'image' => '',
                'id_sparepart_type' => 2,
                'purchase_price' => '30000',
                'sell_price'      => '35000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_sparepart' => 'AA112',
                'sparepart_name'      => 'Stang Seker',
                'merk' => 'RB',
                'stock' => 15,
                'min_stock' => 4,
                'placement' => 'TGH-KACA-01',
                'image' => '',
                'id_sparepart_type' => 3,
                'purchase_price' => '80000',
                'sell_price'      => '100000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_sparepart' => 'FY155',
                'sparepart_name'      => 'Kampas Rem Depan',
                'merk' => 'Pakem',
                'stock' => 2,
                'min_stock' => 3,
                'placement' => 'BLK-DUS-01',
                'image' => '',
                'id_sparepart_type' => 4,
                'purchase_price' => '25000',
                'sell_price'      => '30000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
