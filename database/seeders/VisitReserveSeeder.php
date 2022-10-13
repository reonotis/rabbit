<?php

namespace Database\Seeders;

use App\Models\VisitReserve;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitReserveSeeder extends Seeder
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
                'customer_id' => 1,
                'shop_id' => 1,
                'user_id' => 1,
                'visit_date' => \Carbon\Carbon::now()->format("Y-m-d"),
                'time_section' => '2',
                'visit_time' => '12:00',
                'finish_time' => '13:00',
                'memo' => 'memomemo',
            ],[
                'id' => 2,
                'customer_id' => 2,
                'shop_id' => 1,
                'user_id' => 1,
                'visit_date' => \Carbon\Carbon::now()->format("Y-m-d"),
                'time_section' => '2',
                'visit_time' => '13:00',
                'finish_time' => '14:00',
                'memo' => 'memomemo',
            ],[
                'id' => 3,
                'customer_id' => 3,
                'shop_id' => 1,
                'user_id' => 1,
                'visit_date' => \Carbon\Carbon::now()->format("Y-m-d"),
                'time_section' => '4',
                'visit_time' => '12:30',
                'finish_time' => '14:30',
                'memo' => 'memomemo',
            ],[
                'id' => 4,
                'customer_id' => 4,
                'shop_id' => 1,
                'user_id' => 1,
                'visit_date' => \Carbon\Carbon::now()->format("Y-m-d"),
                'time_section' => '3',
                'visit_time' => '12:30',
                'finish_time' => '14:00',
                'memo' => 'memomemo',
            ]
        ];
        DB::table('visit_reserves')->insert($insertData);

        // 上記のデータにプラスで100件randomデータを作成する
        VisitReserve::factory()->count(1000)->create();
    }
}


