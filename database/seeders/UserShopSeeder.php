<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserShopSeeder extends Seeder
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
                'shop_id' => 1,
                'user_id' => 1,
            ],[
                'id' => 2,
                'shop_id' => 2,
                'user_id' => 1,
            ]
        ];

        DB::table('user_shops')->insert($insertData);
    }
}
