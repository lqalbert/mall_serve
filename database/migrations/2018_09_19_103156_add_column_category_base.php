<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCategoryBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_base', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_display')->default(0)->after('level')->comment('前台是否展示 0是 1否');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_base', function (Blueprint $table) {
            $table->dropColumn('is_display');
        });
    }
}
