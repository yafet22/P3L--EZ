<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'supplier_name'      => 'PT Astra',
                'supplier_address'      => 'Jalan Solo',
                'supplier_phone_number'      => '023897066',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'supplier_name'      => 'PT Sinar Jaya',
                'supplier_address'      => 'Jalan Santai',
                'supplier_phone_number'      => '023885500',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'supplier_name'      => 'PT Ban Jaya',
                'supplier_address'      => 'Jalan Bantul',
                'supplier_phone_number'      => '023437033',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'supplier_name'      => 'PT Sinar Raharjo',
                'supplier_address'      => 'Jalan Malioboro',
                'supplier_phone_number'      => '023227047',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
