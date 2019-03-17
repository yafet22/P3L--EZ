<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            [
                'branch_name'      => 'Babarsari',
                'branch_address'      => 'Jalan Babarsari',
                'branch_phone_number'      => '023557788',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'branch_name'      => 'Seturan',
                'branch_address'      => 'Jalan Seturan',
                'branch_phone_number'      => '023669955',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'branch_name'      => 'Jakal',
                'branch_address'      => 'Jalan Kaliurang',
                'branch_phone_number'      => '023437075',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'branch_name'      => 'Jombor',
                'branch_address'      => 'Jalan Magelang',
                'branch_phone_number'      => '023193847',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
