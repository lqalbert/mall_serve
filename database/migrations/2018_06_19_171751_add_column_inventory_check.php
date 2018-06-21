<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInventoryCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_check', function (Blueprint $table) {
            $table->unsignedInteger('entrepot_id')->nullable()->comment('配送中心ID')->after('check_user_id');
            $table->string('entrepot_name')->nullable()->comment('配送中心')->after('entrepot_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_check', function (Blueprint $table) {
            $table->dropColumn(['entrepot_id','entrepot_name']);
        });
    }
}
