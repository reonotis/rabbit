<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertData = array();
        for($i = 1 ; $i < 10 ; $i++ ){
            $insertData[] = [
                'f_name' => 'f_name_' . str_pad($i, 3, 0, STR_PAD_LEFT),
                'l_name' => 'l_name_' . str_pad($i, 3, 0, STR_PAD_LEFT),
                'f_read' => 'f_read_' . str_pad($i, 3, 0, STR_PAD_LEFT),
                'l_read' => 'l_read_' . str_pad($i, 3, 0, STR_PAD_LEFT),
                'sex' => 1,
                'tel' => '090-1234-5678',
                'email' => 'test_' . str_pad($i, 3, 0, STR_PAD_LEFT) . '@test.jp',
                'zip21' => '100',
                'zip22' => '0001',
                'pref21' => '東京都',
                'address21' => '〇〇区',
                'street21' => '住所が入ります',
                'memo' => 'メモが入りますメモが入りますメモが入りますメモが入りますメモが入りますメモが入りますメモが入ります',
            ];
        }
        DB::table('customers')->insert($insertData);

        Customer::factory()->count(100)->create();
    }
}
