<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_goods', function (Blueprint $table) {
            $table->decimal('refund_price',8,2)->nullable()->comment('退款金额');
            $table->unsignedInteger('return_inventory')->nullable()->comment('退换货入库数量');
            $table->unsignedInteger('destroy_num')->nullable()->comment('退换货出库数量');
            
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
            $table->dropColumn(['refund_price', 'return_inventory', 'destroy_num']);
        });
    }
}
