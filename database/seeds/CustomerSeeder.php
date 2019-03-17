<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'customer_name'      => 'Aga',
                'customer_address'      => 'Jalan Magelang',
                'customer_phone_number'      => '088550343221',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_name'      => 'Vian',
                'customer_address'      => 'Jalan Seturan',
                'customer_phone_number'      => '089909192223',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_name'      => 'Yudha',
                'customer_address'      => 'Jalan Babarsari',
                'customer_phone_number'      => '083123453667',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_name'      => 'Loly',
                'customer_address'      => 'Jalan Babarsari',
                'customer_phone_number'      => '085123010336',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
