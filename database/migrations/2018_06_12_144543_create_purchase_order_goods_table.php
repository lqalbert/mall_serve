<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_order_id')->nullable()->comment('采购单ID');
            $table->unsignedInteger('goods_id')->nullable()->comment('商品ID');
            $table->string('sku_sn',20)->nullable()->comment('商品sku');
            $table->string('category',20)->nullable()->comment('商品类型');
            $table->string('specifications',20)->nullable()->comment('商品规格');
            $table->string('goods_name',20)->nullable()->comment('商品名称');
            $table->string('goods_purchase_num',10)->nullable()->comment('采购数量');
            $table->string('goods_purchase_price',10)->nullable()->comment('采购价格');
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
        Schema::dropIfExists('purchase_order_goods');
    }
}
