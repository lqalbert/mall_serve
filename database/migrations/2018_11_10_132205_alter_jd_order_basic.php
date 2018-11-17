<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterJdOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_deduce_inventory')->default(0)->comment('是否扣除库存 0 未 1已');
            $table->unsignedTinyInteger('is_deposit_return')->default(0)->comment('是否返还保证金');
            $table->decimal('return_deposit',8,2)->default('0.00')->comment('返还的金额');
            $table->decimal('book_freight',8,2)->default('0.00')->comment('账面运费');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->dropColumn(['is_deduce_inventory','is_deposit_return','return_deposit']);
        });
    }
}
