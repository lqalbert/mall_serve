<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositSet2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_set2', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('type')->default(0)->comment('返还类型 0即时返还 1发货时返还 2签收时返还');
            $table->unsignedTinyInteger('yk')->default(0)->comment('运营比例');
            $table->unsignedTinyInteger('yz')->default(0)->comment('运营比例赠品');
            $table->unsignedTinyInteger('c')->default(0)->comment('仓库扣除');
            $table->unsignedTinyInteger('zn')->default(0)->comment('赠品折扣');
            $table->unsignedTinyInteger('n')->default(0)->comment('内购折扣');
            $table->unsignedTinyInteger('j')->default(0)->comment('京东扣点');
            $table->unsignedTinyInteger('y')->default(0)->comment('运营承担');
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
        Schema::dropIfExists('deposit_set2');
    }
}
