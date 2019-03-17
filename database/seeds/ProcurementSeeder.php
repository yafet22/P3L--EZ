<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('procurements')->insert([
            [
                'procurement_status'      => 'Finish',
                'id_sales'      => 1,
                'date'      => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'procurement_status'      => 'Finish',
                'id_sales'      => 2,
                'date'      => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'procurement_status'      => 'On Progress',
                'id_sales'      => 3,
                'date'      => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'procurement_status'      => 'On Progress',
                'id_sales'      => 4,
                'date'      => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
