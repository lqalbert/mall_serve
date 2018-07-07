<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class AddFinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new Role();
        $administrator->name = 'finance';
        $administrator->display_name = '财务';
        $administrator->description = '财务角色';
        $administrator->save();
    }
}
