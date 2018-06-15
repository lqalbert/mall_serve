<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualDeliveryGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_delivery_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_order_id')->nullable()->comment('采购单ID');
            $table->unsignedInteger('actual_delivery_expresses_id')->nullable()->comment('实际发货单ID');
            $table->string('express_num',20)->nullable()->comment('快递单号');
            $table->unsignedInteger('goods_id')->nullable()->comment('商品ID');
            $table->string('sku_sn',20)->nullable()->comment('商品sku');
            $table->string('category',20)->nullable()->comment('商品类型');
            $table->string('specifications',20)->nullable()->comment('商品规格');
            $table->string('goods_name',20)->nullable()->comment('商品名称');
            $table->string('actual_goods_num',10)->nullable()->comment('实际发货数');
            $table->string('every_case_goods_num',10)->nullable()->comment('每箱商品数');
            $table->string('goods_case_num',10)->nullable()->comment('该类商品使用的纸箱数');
            $table->string('goods_case_weight',10)->nullable()->comment('该类商品总重量');
            $table->string('goods_manufacture_time',20)->nullable()->comment('商品生产日期');
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
        Schema::dropIfExists('actual_delivery_goods');
    }
}
