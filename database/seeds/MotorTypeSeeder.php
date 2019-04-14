<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MotorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motorcycle_types')->insert([
            [
                'motorcycle_type_name'      => 'Mio',
                'id_motorcycle_brand'      => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'motorcycle_type_name'      => 'Vario',
                'id_motorcycle_brand'      => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'motorcycle_type_name'      => 'Satria',
                'id_motorcycle_brand'      => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'motorcycle_type_name'      => 'Ninja',
                'id_motorcycle_brand'      => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
