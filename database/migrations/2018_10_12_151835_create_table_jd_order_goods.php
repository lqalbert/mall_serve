<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJdOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_order_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->char("order_sn",16)->nullable()->comment('订单号');
            $table->char("goods_id",16)->nullable()->comment('商品ID');
            $table->char('sku_sn',16)->nullable()->comment('货号');
            $table->string("goods_name")->nullable()->comment('商品名称');
            $table->unsignedInteger("goods_num")->comment('订购数量');
            $table->decimal("goods_price",8,2)->default('0.00')->comment('京东价');
            $table->unsignedInteger("entrepot_id")->comment('仓库id');
            $table->string("entrepot_name")->nullable()->comment('仓库名称');
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
        Schema::dropIfExists('jd_order_goods');
    }
}
