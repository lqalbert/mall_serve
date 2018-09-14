<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldSampleBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sample_basic', function (Blueprint $table) {
            $table->unsignedInteger('entrepot_id')->comment('配送中心(仓库)id')->after('id');
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
            $table->dropColumn('entrepot_id');
        });
    }
}
