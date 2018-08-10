<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFrontGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_goods', function (Blueprint $table) {
//             $table->increments('id');
//             $table->timestamps();
            $table->integer('goods_id')->unsigned()->comment('商品ID');
            $table->integer('front_id')->unsigned()->comment('分类ID');
            
            $table->foreign('goods_id')->references('id')->on('goods_basic')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('front_id')->references('id')->on('category_front')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->primary(['goods_id', 'front_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_goods');
    }
}
