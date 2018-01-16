<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_categories', function (Blueprint $table) {
//             $table->increments('id');
//             $table->timestamps();

            $table->integer('goods_id')->unsigned();
            $table->integer('cate_id')->unsigned();
            
            $table->foreign('goods_id')->references('id')->on('goods_basic')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cate_id')->references('id')->on('category_base')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->primary(['goods_id', 'cate_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_categories');
    }
}
