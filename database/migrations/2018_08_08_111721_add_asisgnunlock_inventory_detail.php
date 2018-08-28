<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAsisgnunlockInventoryDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_detail', function (Blueprint $table) {
            $table->integer('assign_unlock')->nullable()->comment('发货解锁');
            $table->integer('send_ing')->nullable()->comment('发货在途');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_detail', function (Blueprint $table) {
            $table->dropColumn(['assign_unlock','send_ing']);
        });
    }
}
