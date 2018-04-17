<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGoodsBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('new_goods')->default(0)->comment('新品首发');
            $table->unsignedTinyInteger('hot_goods')->default(0)->comment('畅销精品');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods_basic', function (Blueprint $table) {
            $table->dropColumn(['new_goods','hot_goods']);
        });
    }
}
