<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MotorBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motorcycle_brands')->insert([
            [
                'motorcycle_brand_name'      => 'Yamaha',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'motorcycle_brand_name'      => 'Honda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'motorcycle_brand_name'      => 'Suzuki',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'motorcycle_brand_name'      => 'Kawasaki',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
