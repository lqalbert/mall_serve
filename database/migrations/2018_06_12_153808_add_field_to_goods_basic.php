<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToGoodsBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods_basic', function (Blueprint $table) {
            $table->string('specifications')->nullable()->comment('商品规格');

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
            $table->dropColumn(['specifications']);
        });
    }
}
