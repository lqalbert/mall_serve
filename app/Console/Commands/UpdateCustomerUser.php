<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCustomerUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_user:reconnect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '重新设置customer_user中的小组部门关联';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //customer_user 表里面有 group_id department_id 与 user_basic 表里不一至的
        //需要纠正
        $affected = 0;
        DB::table('customer_user')
        ->join('user_basic','customer_user.user_id','=','user_basic.id')
        ->where(function($query){
            $query->where('customer_user.group_id','<>','user_basic.group_id')
            ->orWhere('customer_user.department_id', '<>', 'user_basic.department_id');
        })->whereNull('customer_user.deleted_at')
        ->select('customer_user.id', 'customer_user.user_id','customer_user.group_id','customer_user.department_id','user_basic.group_id as u_group_id','user_basic.department_id as u_department_id')
        ->distinct()
        ->orderBy('id')
        ->chunk(100, function($result) use($affected) {
            foreach ($result as $item) {
                $affected += DB::update('update customer_user set group_id = ?  ,department_id = ? where id= ? ', [$item->u_group_id, $item->u_department_id, $item->id]);
            }
        });
        
        $this->info('done1:'.$affected);
        
//         $this->info('order1:');
        
//         $affected = 0;
//         DB::table('order_basic')
//         ->join('user_basic','order_basic.user_id','=','user_basic.id')
//         ->where(function($query){
//             $query->where('order_basic.group_id','<>','user_basic.group_id')
//             ->orWhere('order_basic.department_id', '<>', 'user_basic.department_id');
//         })->whereNull('order_basic.deleted_at')
//         ->select('order_basic.id', 'order_basic.user_id','order_basic.group_id','order_basic.department_id','user_basic.group_id as u_group_id','user_basic.department_id as u_department_id')
//         ->distinct()
//         ->orderBy('id')
//         ->chunk(100, function($result) use($affected) {
//             foreach ($result as $item) {
//                 $affected += DB::update('update order_basic set group_id = ?  ,department_id = ? where id= ? ', [$item->u_group_id, $item->u_department_id, $item->id]);
//             }
//         });
        
//         $this->info('done2:'.$affected);
        
        
    }
}
