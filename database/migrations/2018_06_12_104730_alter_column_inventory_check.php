<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnInventoryCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_check', function (Blueprint $table) {
            $table->unsignedTinyInteger('check_status')->default(1)->after('check_user_id')->comment('盘点状态1未2是');
            $table->string('remark')->after('check_status')->nullable()->comment('备注');
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
            $table->dropColumn(['check_status','remark']);
        });
    }
}
