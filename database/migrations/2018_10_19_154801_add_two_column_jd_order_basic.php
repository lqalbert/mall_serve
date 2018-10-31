<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnJdOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->string('flag',15)->nullable()->after('is_toplife')->comment('批次标识');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->dropColumn(['order_account']);
        });
    }
}
