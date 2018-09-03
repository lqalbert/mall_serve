<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCombo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_combo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('combo_id')->comment('套装的ID');
            $table->unsignedInteger('goods_id')->comment('关联的商品id');
            $table->string('name',50)->commnet();
            $table->decimal('price',8,2)->default('0.00')->comment('价格');
            $table->unsignedTinyInteger('num')->default(0)->comment('数量');
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
        Schema::dropIfExists('goods_combo');
    }
}
