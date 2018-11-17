<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJdDepositDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_deposit_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedTinyInteger('type')->default(1)->comment('1商品 2赠品');
            $table->decimal('amount',8,2)->default('0.00')->comment('总金额 不打折的');
            $table->decimal('deposit',8,2)->default('0.00')->comment('扣的钱');
            $table->decimal('saler_point',8,2)->default('0.00')->comment('运营费');
            $table->decimal('entrepot_point',8,2)->default('0.00')->comment('仓储费');
            $table->decimal('thirdpart_point',8,2)->default('0.00')->comment('京东扣');
            $table->decimal('freight',8,2)->default('0.00')->comment('快递费');
            $table->decimal('return_deposit')->default('0.00')->comment('返还');
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
        Schema::dropIfExists('jd_deposit_detail');
    }
}
