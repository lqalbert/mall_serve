<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSampleGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sample_id');
            $table->unsignedInteger ('goods_id')->comment ('商品ID');
            $table->string ('goods_name')->comment ('商品名称');
            $table->unsignedInteger('goods_number')->comment ('商品数量');
            $table->decimal('price',8,2)->default('0.00')->comment('价格');
            $table->char('sku_sn',SKU_SN_LENGTH)->nullable()->comment('编号');
            $table->unsignedInteger('sku_id')->nullable()->comment ('SKU_ID');
            $table->string ('sku_name')->nullable()->comment ('SKU名称');
            $table->string('width',6)->nullable()->comment('包装规格宽mm');
            $table->string('height',6)->nullable()->comment('包装规格高mm');
            $table->string('len',6)->nullable()->comment('包装规格长mm');
            $table->string('barcode')->nullable()->comment('条码');
            $table->string('weight',20)->nullable()->comment('重量(g)');
            $table->string('bubble_bag',20)->nullable()->comment('气泡垫(g)');
            $table->string('specifications',20)->nullable()->comment('商品规格');
            $table->string('unit_type',10)->nullable()->comment('商品单位');
            $table->string ('remark')->comment('备注')->nullable();
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
        Schema::dropIfExists('sample_goods');
    }
}
