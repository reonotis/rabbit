<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_histories', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->unsignedInteger('customer_id')->comment('顧客ID');
            $table->unsignedInteger('shop_id')->comment('店舗ID');
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->date('visit_date')->comment('来店予定日');
            $table->time('visit_time')->comment('来店予定時間');
            $table->unsignedInteger('visit_reserve_id')->nullable()->comment('予約していた場合の予約ID');
            $table->unsignedTinyInteger('visit_type')->comment('来店タイプ 1:予約 2:紹介 3:飛び込み');
            $table->unsignedTinyInteger('status')->default('1')->comment('ステータス 1:来店 9:キャンセル');
            $table->unsignedTinyInteger('menu_id')->nullable()->comment('menus.id');

            $table->string('memo', 10000)->nullable()->comment('メモ');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時')	;
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->boolean('delete_flag')->default('0')->comment('削除フラグ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit_histories');
    }
}
