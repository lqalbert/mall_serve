<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertSysNote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_notices', function (Blueprint $table) {
            $table->dropColumn('content');
            
        });
        Schema::table('sys_notices', function (Blueprint $table) {
            $table->text('content')->nullable();
            
        });
        
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_notices', function (Blueprint $table) {
            
        });
    }
}
