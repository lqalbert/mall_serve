<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntrepotBasicAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('entrepot_basic',function (Blueprint $table){

            if (!Schema::hasColumn('entrepot_basic','eng_name')){
                $table->char('eng_name',3)->after('comment')->nullable()->comment('英文简称')->unique();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
