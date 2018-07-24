<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_type', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name',20)->comment('名称');
            $table->unsignedTinyInteger('is_include')->default(0)->comment('是否包邮 0不包 1包');
            $table->unsignedTinyInteger('discount')->default(100)->comment('折扣 100 不打折 60 打6折');
            $table->unsignedTinyInteger('status')->default(1)->comment('1启用 0禁用');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_type');
    }
}
