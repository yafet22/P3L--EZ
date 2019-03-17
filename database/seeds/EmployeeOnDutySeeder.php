<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeeOnDutySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_onduties')->insert([
            [
                'id_employee'      => 1,
                'id_transaction'      => 'SV-031019-1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 2,
                'id_transaction'      => 'SP-031019-2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 1,
                'id_transaction'      => 'SS-031019-3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 2,
                'id_transaction'      => 'SV-031019-4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 3,
                'id_transaction'      => 'SV-031019-1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 4,
                'id_transaction'      => 'SP-031019-2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 3,
                'id_transaction'      => 'SS-031019-3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 4,
                'id_transaction'      => 'SV-031019-4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
