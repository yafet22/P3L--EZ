<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProcurementDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('procurement_details')->insert([
            [
                'price'      => 30000,
                'subtotal' => 60000,
                'amount' => 2,
                'id_procurement' => 1,
                'id_sparepart'      => 'BA113',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'price'      => 25000,
                'subtotal' => 25000,
                'amount' => 1,
                'id_procurement' => 2,
                'id_sparepart'      => 'FY155',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'price'      => 25000,
                'subtotal' => 250000,
                'amount' => 10,
                'id_procurement' => 3,
                'id_sparepart'      => 'FY155',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'price'      => 80000,
                'subtotal' => 400000,
                'amount' => 5,
                'id_procurement' => 4,
                'id_sparepart'      => 'AA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
