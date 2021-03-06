<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToOrderAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_address', function (Blueprint $table) {
            $table->string('fixed_telephone',20)->nullable()->comment('固定电话');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_address', function (Blueprint $table) {
            $table->dropColumn([
                'fixed_telephone',
            ]);
        });
    }
}
