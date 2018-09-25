<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToExpressPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('express_prices', function (Blueprint $table) {
            $table->decimal('second_price')->default(0)->after('first_price')->comment('超过首重时的首价');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('express_prices', function (Blueprint $table) {
            $table->dropColumn(['second_price']);
        });
    }
}
