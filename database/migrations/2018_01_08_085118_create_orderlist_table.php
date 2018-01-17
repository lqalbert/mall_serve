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
            $table->string('order_sn', 60)->comment('销售订单');
            $table->string('order_type', 60)->comment('订单类型');
            $table->timestamp('add_time')->comment('录入日期');
            $table->string('o_shop', 60)->comment('外部订单店铺');
            $table->string('consignee', 60)->comment('收款方');
            $table->integer('employee')->comment('成交员工');
            $table->integer('users')->comment('购买用户');
            $table->string('address', 80)->comment('收货地址');
            $table->string('det_address', 80)->comment('详细收货地址');
            $table->string('user_phone', 80)->comment('收件人手机');
            $table->string('goods_name', 60)->comment('商品名称');
            $table->string('print', 60)->comment('打印');
            $table->enum('order_status', ['pre_pay', 'pre_affirm','done','closed','refund'])->default('pre_pay')->comment('订单状态');
            $table->float('order_all_money',24)->comment('总金额');
            $table->float('order_pay_money',24)->comment('应付金额');
            $table->string('pay_name', 60)->comment('支付方式');
            $table->enum('shipping_status', ['pre_deliver', 'delivered','received'])->comment('发货状态')->nullable();
            $table->enum('check_status', ['0', '1','2'])->comment('审核状态0未通过1通过2未审核');
            $table->string('shipping_name', 60)->comment('配送方式');
            $table->date('order_time')->comment('下单时间');
            $table->softDeletes();
            $table->timestamps();
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
