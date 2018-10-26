<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderAddReturntag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_deposit_return')->default(0)->comment("未返还");
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
            $table->dropColumn('is_deposit_return');
        });
    }
}
