<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MechanicOnDutySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mechanic_onduties')->insert([
            [
                'id_employee'      => 5,
                'id_motorcycle'      => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 5,
                'id_motorcycle'      => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 6,
                'id_motorcycle'      => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 6,
                'id_motorcycle'      => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
