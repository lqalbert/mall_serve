<?php

use Illuminate\Database\Seeder;
use App\Events\AddEmployee;

class UserTableSeeder2 extends Seeder
{
    /**
     * 生成部门 小组 员工数据
     * 
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 10)->create()
        ->each(function($u){
            event( new AddEmployee($u));
        });
    }
}
