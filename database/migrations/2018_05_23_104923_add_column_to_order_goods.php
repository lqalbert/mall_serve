<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_goods', function (Blueprint $table) {
            $table->string('width',6)->nullable()->after('exchange_status')->comment('包装规格宽mm');
            $table->string('height',6)->nullable()->after('width')->comment('包装规格高mm');
            $table->string('len',6)->nullable()->after('height')->comment('包装规格长mm');
            $table->string('barcode')->nullable()->after('length')->comment('条码');
            $table->string('weight',20)->nullable()->after('barcode')->comment('重量(g)');
            $table->string('bubble_bag',20)->nullable()->after('weight')->comment('气泡垫(g)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_goods', function (Blueprint $table) {
            $table->dropColumn(['width','height','length','barcode','weight','bubble_bag']);
        });
    }
}
