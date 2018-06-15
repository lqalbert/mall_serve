<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToEntrepotBasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrepot_basic', function (Blueprint $table) {
            $table->unsignedInteger('area_province_id')->nullable()->comment('省id');
            $table->unsignedInteger('area_city_id')->nullable()->comment('市id');
            $table->unsignedInteger('area_district_id')->nullable()->comment('区/县id');
            $table->string('area_province_name',20)->nullable()->comment('省name');
            $table->string('area_city_name',20)->nullable()->comment('市name');
            $table->string('area_district_name',20)->nullable()->comment('区/县name');
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
        Schema::table('entrepot_basic', function (Blueprint $table) {
            $table->dropColumn([
                'area_province_id',
                'area_city_id',
                'area_district_id',
                'area_province_name',
                'area_city_name',
                'area_district_name',
                'fixed_telephone',
            ]);
        });
    }
}
