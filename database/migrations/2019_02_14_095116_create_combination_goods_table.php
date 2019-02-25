<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombinationGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combination_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plan_id',32)->comment('方案编号');
            $table->string('type',32)->comment('商品类型');
            $table->string('name',64)->comment('商品名称');
            $table->unsignedTinyInteger('number')->default(0)->comment('商品数量');
            $table->string('efficacy',255)->comment('商品功效');
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
        Schema::dropIfExists('combination_goods');
    }
}
