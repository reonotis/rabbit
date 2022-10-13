<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertData = [
            [
                'id' => 1,
                'shop_name' => 'CASTLE',
                'shop_symbol' => 'CA',
                'email' => 'test@test.jp',
                'tel' => '',
                'img_pass' => '',
                'start_time' => '10:00',
                'end_time' => '21:00',
                'last_reception_time' => '20:00',
            ],[
                'id' => 2,
                'shop_name' => 'DELTA',
                'shop_symbol' => 'DE',
                'email' => 'test2@test.jp',
                'tel' => '',
                'img_pass' => '',
                'start_time' => '10:00',
                'end_time' => '21:00',
                'last_reception_time' => '20:00',
            ],[
                'id' => 3,
                'shop_name' => 'ARCHE',
                'shop_symbol' => 'AR',
                'email' => 'test3@test.jp',
                'tel' => '',
                'img_pass' => '',
                'start_time' => '10:00',
                'end_time' => '21:00',
                'last_reception_time' => '20:00',
            ]
        ];

        DB::table('shops')->insert($insertData);
    }
}


