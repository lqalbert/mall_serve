<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\CustomerBasic;
use App\Models\OrderBasic;

class OrderFillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        OrderBasic::whereNull('user_id')->orderBy('id','desc')->chunk(100, function ($orders) {
            foreach ($orders as $order) {
                $cusModel = CustomerBasic::find($order->cus_id);
                $ownerBusness = $cusModel->midRelative;
                $user = User::find($ownerBusness->user_id);
                $group = $user->group()->select(['id','name'])->first();
                $department = $user->department()->select(['id','name'])->first();
                
                $order->user_id = $user->id;
                $order->user_id = $user->realname;
               
                $order->group_name = $group ? $group->name : null ;
                $order->department_name = $department ? $department->name : null;
                
                $order->save();
            }
        });
    }
}
