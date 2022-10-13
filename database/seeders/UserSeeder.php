<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'name' => 'fujisawa',
                'email' => 'fujisawa@reonotis.jp',
                'password' => Hash::make('test'),
                'authority_level' => 2,
            ],[
                'name' => 'fujisawa2',
                'email' => 'test2@test.jp',
                'password' => Hash::make('test'),
                'authority_level' => 2,
            ],[
                'name' => 'fujisawa3',
                'email' => 'test3@test.jp',
                'password' => Hash::make('test'),
                'authority_level' => 2,
            ]
        ];

        DB::table('users')->insert($insertData);

        // 上記のデータにプラスで100件randomデータを作成する
        User::factory()->count(100)->create();
    }
}

