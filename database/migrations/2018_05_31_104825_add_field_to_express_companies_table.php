<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToExpressCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('express_companies', function (Blueprint $table) {
            $table->unsignedInteger('entrepot_id')->nullable()->comment('配送中心ID');
            $table->string('entrepot_name',20)->nullable()->comment('配送中心名称');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('express_companies', function (Blueprint $table) {
            $table->dropColumn(['entrepot_id','entrepot_name']);
        });
    }
}
