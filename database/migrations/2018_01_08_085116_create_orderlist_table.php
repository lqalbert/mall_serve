<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderlist', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('order_sn', 60)->comment('销售订单');
            $table->string('order_type', 60)->comment('订单类型');
            $table->string('add_time', 60)->comment('录入日期');
            $table->string('o_shop', 60)->comment('外部订单店铺');
            $table->string('consignee', 60)->comment('收款方');
            $table->string('goods_name', 60)->comment('商品名称');
            $table->string('print', 60)->comment('打印');
            $table->string('order_status', 60)->comment('订单状态');
            $table->string('order_all_money', 60)->comment('总金额');
            $table->string('order_pay_money', 60)->comment('应付金额');
            $table->string('pay_name', 60)->comment('支付方式');
            $table->string('shipping_status', 60)->comment('发货状态');
            $table->string('shipping_name', 60)->comment('配送方式');
            $table->string('order_time', 60)->comment('下单时间');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
