<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWasteReasonToAssignBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_basic', function (Blueprint $table) {
            if (!Schema::hasColumn('assign_basic','waste_reason')){
                $table->string('waste_reason',300)->nullable()->comment('废单原因');
            }
            if (!Schema::hasColumn('assign_basic','contact_content')){
                $table->string('contact_content',300)->nullable()->comment('沟通明细');
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
        //
    }
}
