<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SparepartTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sparepart_types')->insert([
            [
                'sparepart_type_name'      => 'Sparepart Roda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sparepart_type_name'      => 'Sparepart Kelistrikan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sparepart_type_name'      => 'Sparepart Mesin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sparepart_type_name'      => 'Sparepart Rem',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
