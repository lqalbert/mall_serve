<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_sn',20)->nullable()->comment('采购单号');
            $table->string('shipper',20)->nullable()->comment('发货单位');
            $table->unsignedInteger('entrepot_id')->nullable()->comment('配送中心ID');
            $table->string('entrepot_name',20)->nullable()->comment('配送中心名称');
            $table->string('contact_time',20)->nullable()->comment('到货时间');
            $table->string('contact_name',20)->nullable()->comment('采购人名字');
            $table->string('contact_phone',20)->nullable()->comment('采购人手机号');
            $table->string('sku_type',20)->nullable()->comment('SKU种类');
            $table->string('goods_total',20)->nullable()->comment('商品总数量');
            $table->string('goods_money_total',20)->nullable()->comment('商品总金额');
            $table->string('purchase_status',10)->default(1)->comment('采购状态 1 待审核 2 已审核 3 已发货 4 已完结');
            $table->string('warehousing_status',10)->default(1)->comment('入库状态 1 未入库 2 已入库 ');
            $table->string('settlement_status',10)->default(1)->comment('结算状态 1 未结算 2 已结算 ');

            $table->string('remark',100)->nullable()->comment('备注');
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
        Schema::dropIfExists('purchase_orders');
    }
}
