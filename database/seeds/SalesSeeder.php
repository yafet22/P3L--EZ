<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->insert([
            [
                'sales_name'      => 'Tono',
                'id_supplier'      => '1',
                'sales_phone_number'      => '023897066',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sales_name'      => 'Toni',
                'id_supplier'      => '2',
                'sales_phone_number'      => '023885500',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sales_name'      => 'Budi',
                'id_supplier'      => '3',
                'sales_phone_number'      => '023437033',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sales_name'      => 'Andy',
                'id_supplier'      => '4',
                'sales_phone_number'      => '023227047',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
