<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderBasicAddinludeFreight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->decimal('book_freight')->default('0.00')->comment('包邮时的 账面邮费');
            $table->decimal('deposit')->default('0.00')->comment('要扣除的保证金');
            $table->decimal('return_deposit')->default('0.00')->comment('要返还的保证金');
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
            $table->dropColumn(['book_freight','deposit','return_deposit']);
        });
    }
}
