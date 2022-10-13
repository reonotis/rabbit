<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_reserves', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->unsignedInteger('customer_id')->comment('顧客ID');
            $table->unsignedInteger('shop_id')->comment('店舗ID');
            $table->unsignedInteger('user_id')->nullable()->comment('ユーザーID');
            $table->date('visit_date')->comment('来店予定日');
            $table->unsignedTinyInteger('time_section')->default('1')->comment('所要時間 1:30min 2:60min 3:90min');
            $table->time('visit_time')->comment('来店予定時間');
            $table->time('finish_time')->comment('施術終了予定時間');

            $table->unsignedTinyInteger('status')->default('0')->comment('ステータス 0:予約 1:来店済み 9:キャンセル');

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
        Schema::dropIfExists('visit_reserves');
    }
}
