<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrderBasicAddFreight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('include_freight')->nullable()->comment("是否包邮 0不包 1包 nullable 是为了 早期订单还没设置包邮时的状态");
            $table->decimal('freight',8,2)->default('0.00')->comment('自付 运费 特例，顺丰包邮 还要加收12元邮费');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->dropColumn(['include_freight','freight']);
        });
    }
}
