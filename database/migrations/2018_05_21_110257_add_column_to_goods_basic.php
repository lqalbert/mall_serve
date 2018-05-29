<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToGoodsBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods_basic', function (Blueprint $table) {
            $table->string('width',6)->nullable()->comment('包装规格宽mm');
            $table->string('height',6)->nullable()->comment('包装规格高mm');
            $table->string('len',6)->nullable()->comment('包装规格长mm');
            $table->string('barcode')->nullable()->comment('条码');
            $table->string('weight',20)->nullable()->comment('重量(g)');
            $table->string('bubble_bag',20)->nullable()->comment('气泡垫(g)');
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
            $table->dropColumn(['width','height','length','barcode','weight','bubble_bag']);
        });
    }
}
