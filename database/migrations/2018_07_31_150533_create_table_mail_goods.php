<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMailGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('mail_id')->comment("关联的ID");
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->unsignedInteger('sku_id')->comment('sku_id');
            $table->char('sku_sn',50)->comment('编号');
            $table->string('goods_name',50)->nullable()->comment('商品名称');
            $table->string('sku_name',50)->nullable()->comment('SKU名称');
            $table->decimal('price',8,2)->default('0.00')->comment('单价0.00');
            $table->string('remark',200)->nullable()->comment('备注');
            $table->string('unit_type',10)->comment('单位');
            $table->string('width',6)->nullable()->comment('宽');
            $table->string('height',6)->nullable()->comment('高');
            $table->string('len',6)->nullable()->comment('长');
            $table->string('barcode',200)->nullable()->comment('条形码');
            $table->string('weight',20)->nullable()->comment('重量g');
            $table->string('bubble_bag',20)->nullable()->comment('气泡垫');
            $table->string('specifications',20)->nullable()->comment('商品规格');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_goods');
    }
}
