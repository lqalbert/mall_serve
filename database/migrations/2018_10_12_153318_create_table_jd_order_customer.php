<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJdOrderCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_order_customer', function (Blueprint $table) {
            $table->increments('id');
            $table->char("order_sn",16)->nullable()->comment('订单号');
            $table->string("cus_name")->nullable()->comment('客户姓名');
            $table->string("tel")->nullable()->comment('联系电话');
            $table->string("order_account")->nullable()->comment('下单帐号');
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
        Schema::dropIfExists('jd_order_customer');
    }
}
