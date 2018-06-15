<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterExpress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE express_companies  MODIFY COLUMN eng VARCHAR(20)  NULL; ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE express_companies  MODIFY COLUMN eng char(2)  NULL; ');
    }
}
