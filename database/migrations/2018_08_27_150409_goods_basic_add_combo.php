<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GoodsBasicAddCombo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('combo')->default(0)->comment('是否是套餐');
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
            $table->dropColumn('combo');
        });
        
    }
}
