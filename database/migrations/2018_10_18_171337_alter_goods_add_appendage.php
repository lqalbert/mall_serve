<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGoodsAddAppendage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_appendage')->default(0)->comment('是不是赠品');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods_basic', function (Blueprint $table) {
            $table->dropColumn('is_appendage');
        });
    }
}
