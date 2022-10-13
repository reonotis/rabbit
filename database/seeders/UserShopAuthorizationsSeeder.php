<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserShopAuthorizationsSeeder extends Seeder
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
                'user_shop_id' => 1,
                'user_read' => 1,
                'user_create' => 1,
                'user_edit' => 1,
                'user_delete' => 1,
                'customer_read' => 1,
                'customer_create' => 1,
                'customer_edit' => 1,
                'customer_delete' => 1,
                'reserve_read' => 1,
                'reserve_create' => 1,
                'reserve_edit' => 1,
                'reserve_delete' => 1,
            ],[
                'id' => 2,
                'user_shop_id' => 2,
                'user_read' => 1,
                'user_create' => 1,
                'user_edit' => 1,
                'user_delete' => 1,
                'customer_read' => 1,
                'customer_create' => 1,
                'customer_edit' => 1,
                'customer_delete' => 1,
                'reserve_read' => 1,
                'reserve_create' => 1,
                'reserve_edit' => 1,
                'reserve_delete' => 1,
            ]
        ];

        DB::table('user_shop_authorizations')->insert($insertData);
    }
}
