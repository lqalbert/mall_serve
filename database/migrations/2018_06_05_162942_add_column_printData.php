<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPrintData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_basic', function (Blueprint $table) {
            $table->text('print_data')->nullable()->comment('获取到的打印数据');
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
            $table->dropColumn(['print_data']);
        });
    }
}
