<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInventoryDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->unsignedInteger('entrepot_id')->comment('配送中心ID');
            $table->string('entrepot_name',20)->comment('配送中心');
            $table->char('sku_sn', 50)->comment('商品编号');
            $table->string('goods_name', 50)->comment('商品名称');
            $table->unsignedInteger('produce_in')->nullable()->comment('生产入库');
            $table->unsignedInteger('produce_out')->nullable()->comment('生产出库');
            $table->integer('sale_lock')->nullable()->comment('销售锁定');
            $table->integer('assign_lock')->nullable()->comment('发货锁定');
            $table->integer('exchange_lock')->nullable()->comment('换货锁定');
            
            $table->unsignedInteger('user_id')->comment('操作人ID');
            $table->string('user_name')->comment('操作人姓名');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_detail');
    }
}
