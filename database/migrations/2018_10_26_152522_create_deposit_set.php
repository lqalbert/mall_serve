<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_set', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('type')->default(0)->comment('返还类型 0即时返还 1发货时返还 2签收时返还');
            $table->unsignedTinyInteger('appendage_rate')->default(0)->comment('赠品扣除比例 百分数数字部分');
            $table->unsignedTinyInteger('sale_rate')->default(0)->comment('正常销售扣除比例 百分数数字部分');
            $table->unsignedTinyInteger('return_rate')->default(0)->comment('返还比例 百分数数字部分');
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
        Schema::dropIfExists('deposit_set');
    }
}
