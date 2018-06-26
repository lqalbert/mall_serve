<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExpressCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('express_companies', function (Blueprint $table) {
            $table->text('send_address')->nullable()->comment('发货地址');
            $table->string('printer',30)->nullable()->comment('打印机名称');
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
            $table->dropColumn(['send_address','printer']);
        });
    }
}
