<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompatibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('compatibilities')->insert([
            [
                'id_motorcycle_type'      => 1,
                'id_sparepart'      => 'AA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 1,
                'id_sparepart'      => 'BA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 1,
                'id_sparepart'      => 'BA113',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 1,
                'id_sparepart'      => 'FY155',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 2,
                'id_sparepart'      => 'AA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 2,
                'id_sparepart'      => 'BA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 2,
                'id_sparepart'      => 'BA113',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 2,
                'id_sparepart'      => 'FY155',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 3,
                'id_sparepart'      => 'AA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 3,
                'id_sparepart'      => 'BA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 3,
                'id_sparepart'      => 'BA113',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 3,
                'id_sparepart'      => 'FY155',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 4,
                'id_sparepart'      => 'AA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 4,
                'id_sparepart'      => 'BA112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 4,
                'id_sparepart'      => 'BA113',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 4,
                'id_sparepart'      => 'FY155',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
