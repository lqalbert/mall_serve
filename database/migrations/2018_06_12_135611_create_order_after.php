<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAfter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_after', function (Blueprint $table) {
            $table->increments('id');
            $table->char('return_sn',16)->nullable()->comment('退换货单编号');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->char('order_sn', DAN_LENGTH)->comment('订单号');
            $table->unsignedInteger('entrepot_id')->comment('配送中心');
            $table->unsignedInteger('cus_id')->comment('客户id');
            $table->string('return_unit',30)->nullable()->comment('退款单位');
            $table->decimal('return_fee',8,2)->nullable()->comment('退货运费');
            $table->string('receive_unit',30)->nullable()->comment('收货单位');
            $table->string('resend_unit',30)->nullable()->comment('重发货单位');
            $table->string('express',30)->nullable()->comment('退货快递公司');
            $table->string('express_sn',30)->nullable()->comment('退货快递单号');
            $table->decimal('service_fee',8,2)->nullable()->comment('退货服务费');
            $table->unsignedTinyInteger('pay_at_return')->default(0)->comment('退货到付');
            $table->unsignedTinyInteger('is_special')->default(0)->comment('是否特殊处理');
            $table->decimal('fee',8,2)->default('0.00')->comment('退款金额');
            $table->string('user_name')->comment('退货发起人');
            $table->unsignedTinyInteger('user_id')->comment('退货发起人');
            $table->string('remark')->nullable()->comment('退货备注信息');
            $table->unsignedTinyInteger('status')->default(0)->comment('0 未处理　1已审核　2已确认');
            $table->timestamp('sure_at')->nullable()->comment('确认时间');
            $table->timestamp('check_at')->nullable()->comment('审核时间');
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
        Schema::dropIfExists('order_after');
    }
}
