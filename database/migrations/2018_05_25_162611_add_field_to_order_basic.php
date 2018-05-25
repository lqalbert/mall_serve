<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->string('express_delivery',3)->nullable()->comment('是否指定快递');
            $table->unsignedInteger('express_id')->nullable()->comment('快递公司ID');
            $table->string('order_remark',20)->nullable()->comment('快递公司名称');
            $table->string('express_remark',200)->nullable()->comment('订单收单备注');
            $table->string('express_name',200)->nullable()->comment('配送发货备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->dropColumn(['express_delivery','express_id','order_remark','express_remark','express_name']);
        });
    }
}
