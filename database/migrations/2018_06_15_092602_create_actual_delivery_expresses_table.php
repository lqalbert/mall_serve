<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualDeliveryExpressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_delivery_expresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_order_id')->nullable()->comment('采购单ID');
            $table->string('postage',20)->nullable()->comment('邮费金额');
            $table->string('express_num',20)->nullable()->comment('快递单号');
            $table->string('express_company',20)->nullable()->comment('快递公司名称');
            $table->string('total_case_num',10)->nullable()->comment('纸箱总数');
            $table->string('confirm_user',10)->nullable()->comment('确认发货人');
            $table->string('deliver_goods_time',20)->nullable()->comment('发货时间');
            $table->string('remarks',100)->nullable()->comment('备注');
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
        Schema::dropIfExists('actual_delivery_expresses');
    }
}
