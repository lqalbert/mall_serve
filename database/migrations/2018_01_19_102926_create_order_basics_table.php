<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBasicsTable extends Migration
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
            $table->unsignedInteger('cus_id')->comment('客户ID');
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->string('goods_name')->comment('商品名称');
            $table->string('category_id')->comment('商品类型ID');
            $table->unsignedInteger('goods_number')->comment('商品数量');
            $table->string('remark')->comment('备注');
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
