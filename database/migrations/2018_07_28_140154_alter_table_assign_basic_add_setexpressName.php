<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAssignBasicAddSetexpressName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_basic', function (Blueprint $table) {
            $table->string('set_express_name',10)->nullable()->after('set_express')->comment('指定快递名 实际是运费模板');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assign_basic', function (Blueprint $table) {
            $table->dropColumn('set_express_name');
        });
    }
}
