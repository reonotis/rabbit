<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicals', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('f_name')->nullable()->comment('苗字');
            $table->string('l_name')->nullable()->comment('名前');
            $table->string('f_read')->nullable()->comment('ミョウジ');
            $table->string('l_read')->nullable()->comment('ナマエ');
            $table->unsignedTinyInteger('sex')->nullable()->comment('性別');
            $table->string('tel')->nullable()->comment('電話番号');
            $table->string('email')->nullable()->comment('メールアドレス');
            $table->string('zip21', '3')->nullable()->comment('郵便番号1');
            $table->string('zip22', '4')->nullable()->comment('郵便番号2');
            $table->string('pref21')->nullable()->comment('都道府県');
            $table->string('address21')->nullable()->comment('市区町村');
            $table->string('street21')->nullable()->comment('所在');
            $table->unsignedInteger('shop_no')->nullable()->comment('基本来店店舗');
            $table->unsignedInteger('staff_charge')->nullable()->comment('担当スタッフ');
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
        Schema::dropIfExists('medicals');
    }
}
