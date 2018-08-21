<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderAfterAddReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_after', function (Blueprint $table) {
            $table->string('reason')->nullable()->comment('退货原因');
            $table->string('check_mark')->nullable()->comment('审核备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_after', function (Blueprint $table) {
            $table->dropColumn(['reason','check_mark']);
        });
    }
}
