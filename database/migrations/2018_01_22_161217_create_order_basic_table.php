<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_basic', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('deal_id')->comment('成交员工ID')->nullable();
            $table->string('deal_name')->comment('成交员工姓名')->nullable();
            $table->unsignedMediumInteger('auditor_id')->comment('审核员工ID')->nullable()->nullable();
            $table->string('auditor_name')->comment('审核员工姓名')->nullable();
            $table->unsignedMediumInteger('cus_id')->comment('购买用户ID')->nullable();
            $table->unsignedMediumInteger('address_id')->comment('收货地址ID')->nullable();
            $table->string('goods_id',60)->comment('商品ID')->nullable();
            $table->enum('order_status', [0,1,2,3,4])->default(0)->comment('订单状态0待付款1待确认2已完成3已关闭4退货中');
            $table->float('order_all_money',24)->comment('总金额')->nullable()->nullable();
            $table->float('order_pay_money',24)->comment('应付金额')->nullable()->nullable();
            $table->enum('shipping_status', [0,1,2])->default(0)->comment('发货状态0待发货1已发货2已收货');
            $table->enum('check_status', [0,1,2])->default(0)->comment('审核状态0未通过1通过2未审核');
            $table->string('distribution_type', 60)->comment('配送方式')->nullable();
            $table->date('auditor_time')->comment('审核时间')->nullable();
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
        Schema::dropIfExists('order_basic');
    }
}
