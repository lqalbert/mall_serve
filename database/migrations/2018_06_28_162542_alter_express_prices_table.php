<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExpressPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('express_prices', function (Blueprint $table) {
                $table->unsignedInteger('first_weight')->default(0)->comment('首重')->change();
                $table->decimal('first_price')->default(0)->comment('首价')->change();
                $table->unsignedInteger('continued_weight')->default(0)->comment('续重')->change();
                $table->decimal('continued_price')->default(0)->comment('续价')->change();
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
//            $table->dropColumn(['first_weight','first_price','continued_weight','continued_price']);
       });
    }
}
