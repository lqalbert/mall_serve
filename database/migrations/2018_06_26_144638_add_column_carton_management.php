<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCartonManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carton_management', function (Blueprint $table) {
            $table->string('carton_volume')->nullable()->comment('纸箱体积');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carton_management', function (Blueprint $table) {
            $table->dropColumn(['carton_volume']);
        });
    }
}
