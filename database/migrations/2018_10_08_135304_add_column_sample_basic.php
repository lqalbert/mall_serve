<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSampleBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sample_basic', function (Blueprint $table) {
            $table->unsignedInteger('department_id')->comment('所属部门id')->after('entrepot_id');
            $table->string('department_name',50)->comment('所属部门名称')->after('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sample_basic', function (Blueprint $table) {
            $table->dropColumn(['department_id','department_name']);
        });
    }
}
