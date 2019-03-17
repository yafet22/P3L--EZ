<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            [
                'name'      => 'Boss',
                'salary'      => 0,
                'phone_number'      => '0',
                'address' => '0',
                'id_user' => 1,
                'id_branch' => 1,
                'id_role' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'      => 'Martin',
                'salary'      => 1000000,
                'phone_number'      => '088798444201',
                'address' => 'Tambak Bayan',
                'id_user' => 2,
                'id_branch' => 1,
                'id_role' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'      => 'Yafet',
                'salary'      => 5000000,
                'phone_number'      => '087734010505',
                'address' => 'Seturan',
                'id_user' => 3,
                'id_branch' => 2,
                'id_role' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'      => 'Ryan',
                'salary'      => 1500000,
                'phone_number'      => '089607555432',
                'address' => 'Gejayan',
                'id_user' => 4,
                'id_branch' => 3,
                'id_role' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'      => 'Panda',
                'salary'      => 2000000,
                'phone_number'      => '086576444321',
                'address' => 'Babarsari',
                'id_user' => 5,
                'id_branch' => 2,
                'id_role' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'      => 'Ray',
                'salary'      => 1200000,
                'phone_number'      => '086576444321',
                'address' => 'Babarsari',
                'id_user' => null,
                'id_branch' => 2,
                'id_role' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'      => 'Hakeem',
                'salary'      => 1200000,
                'phone_number'      => '086576444321',
                'address' => 'Babarsari',
                'id_user' => null,
                'id_branch' => 4,
                'id_role' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
