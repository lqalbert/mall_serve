<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJdOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_order_basic', function (Blueprint $table) {
            $table->increments('id');
            $table->char("order_sn",16)->nullable()->comment('订单号');
            $table->string("order_account")->nullable()->comment('下单帐号');
            $table->dateTime("order_at")->nullable()->comment('下单时间');
            $table->decimal("order_money",8,2)->default('0.00')->comment('订单金额');
            $table->decimal("all_money",8,2)->default('0.00')->comment('结算金额');
            $table->decimal("pay_money",8,2)->default('0.00')->comment('应付金额');
            $table->decimal("pay_balance",8,2)->default('0.00')->comment('余额支付');
            $table->string("status")->nullable()->comment('订单状态');
            $table->string("type")->nullable()->comment('订单类型');
            $table->string("remark")->nullable()->comment('订单备注');
            $table->decimal("express_fee",8,2)->default('0.00')->comment('运费金额');
            $table->string("pay_way")->nullable()->comment('支付方式');
            $table->dateTime("pay_confirm_at")->nullable()->comment('付款确认时间');
            $table->dateTime("end_at")->nullable()->comment('订单完成时间');
            $table->string("order_source")->nullable()->comment('订单来源');
            $table->string("order_channel")->nullable()->comment('订单渠道');
            $table->string("install_service")->nullable()->comment('送装服务');
            $table->decimal("service_fee",8,2)->default('0.00')->comment('服务费');
            $table->string("is_brand")->nullable()->comment('是否为品牌商订单');
            $table->string("is_toplife")->nullable()->comment('是否为toplife订单');
            $table->timestamps();
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
        Schema::dropIfExists('jd_order_basic');
    }
}
