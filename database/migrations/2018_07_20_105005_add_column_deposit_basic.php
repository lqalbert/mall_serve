<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDepositBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('revoke_status')->default(0)->comment('撤销状态 1撤销')->after('charge_department');
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
            $table->dropColumn(['revoke_status']);
        });
    }
}
