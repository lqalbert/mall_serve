<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableInventoryCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('inventory_check');
        Schema::create('inventory_check_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('check_num',15)->nullable()->comment('盘点单号');
            $table->unsignedInteger('check_id')->default(0)->comment('盘点表ID');
            $table->unsignedInteger('inventory_id')->comment('库存ID');
            $table->unsignedInteger('entrepot_id')->comment('配送中心ID');
            $table->string('entrepot_name')->nullable()->comment('配送中心');
            $table->string('goods_name',50)->nullable()->comment('商品名称');
            $table->char('sku_sn', SKU_SN_LENGTH)->comment('商品编号');
            $table->unsignedTinyInteger('cate_type_id')->default(0)->comment('类型ID');
            $table->unsignedTinyInteger('cate_kind_id')->default(0)->comment('分类ID');
            $table->string('cate_type')->comment('商品类型');
            $table->string('cate_kind')->comment('商品品种');
            $table->unsignedInteger('entrepot_count')->default(0)->comment('仓库数量');
            $table->unsignedInteger('check_count')->default(0)->comment('盘点数量');
            $table->float('goods_price',24)->comment('商品单价')->nullable();
            $table->unsignedInteger('profit_count')->default(0)->comment('盘盈数量');
            $table->float('profit_money',24)->nullable()->comment('盘盈金额')->nullable();
            $table->unsignedInteger('loss_count')->default(0)->comment('盘亏数量');
            $table->float('loss_money',24)->nullable()->comment('盘亏金额')->nullable();
            $table->string('check_name',50)->nullable()->comment('盘点人');
            $table->unsignedInteger('check_user_id')->nullable()->comment('盘点人ID');
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_check_goods');
    }
}
