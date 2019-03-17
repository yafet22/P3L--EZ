<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MotorcycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motorcycles')->insert([
            [
                'license_number'      => 'AB 7778 EE',
                'id_motorcycle_type'      => 1,
                'id_customer'      => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'license_number'      => 'AB 6658 CE',
                'id_motorcycle_type'      => 2,
                'id_customer'      => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'license_number'      => 'H 3484 FF',
                'id_motorcycle_type'      => 3,
                'id_customer'      => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'license_number'      => 'B 4879 YM',
                'id_motorcycle_type'      => 4,
                'id_customer'      => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
