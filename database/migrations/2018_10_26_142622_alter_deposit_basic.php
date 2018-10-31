<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDepositBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('action_type')->default(0)->comment('操作类型 0充值');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposit_basic', function (Blueprint $table) {
            $table->dropColumn('action_type');
        });
    }
}
