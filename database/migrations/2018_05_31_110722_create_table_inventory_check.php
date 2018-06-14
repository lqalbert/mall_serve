<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInventoryCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_check', function (Blueprint $table) {
            $table->increments('id');
            $table->char('sku_sn', SKU_SN_LENGTH)->unique()->comment('商品编号');
            $table->unsignedInteger('entrepot_id')->comment('配送中心ID');
            $table->string('goods_name',50)->comment('商品名称');
            $table->unsignedInteger('cate_type_id')->comment('商品类型 大分类 ID');
            $table->unsignedTinyInteger('check_status')->default(1)->comment('盘点状态1是2未');
            $table->unsignedInteger('entrepot_count')->default(0)->comment('仓库数量');
            $table->unsignedInteger('check_count')->default(0)->comment('盘点数量');
            $table->float('goods_price',24)->comment('商品单价')->nullable();

            $table->unsignedInteger('profit_count')->default(0)->comment('盘盈数量');
            $table->float('profit_money',24)->nullable()->comment('盘盈金额')->nullable();

            $table->unsignedInteger('loss_count')->default(0)->comment('盘亏数量');
            $table->float('loss_money',24)->nullable()->comment('盘亏金额')->nullable();

            $table->string('check_name',50)->nullable()->comment('盘点人');
            $table->unsignedInteger('check_id')->nullable()->comment('盘点人ID');
            $table->string('remark')->nullable()->comment('备注');

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
        Schema::dropIfExists('inventory_check');
    }
}
