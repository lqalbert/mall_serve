<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\JdOrderBasic;
use App\Models\JdOrderCustomer;
use App\Models\JdMatchBasic;
use App\Models\CustomerContact;
use App\Models\CustomerUser;
use App\Services\JdOrder\JdOrderService;

class JdOrderMatchUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $jdCustomer;
    private $flag;
    private $jdService= null;
    /**
     * 任务最大尝试次数
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jdCustomer,$flag)
    {
        $this->jdCustomer = $jdCustomer;
        $this->flag = $flag;
        $this->jdService =  resolve('App\\Services\\JdOrder\\JdOrderService'); 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
      public function handle()
      {
          $orders = JdOrderBasic::where('flag', $this->flag)->get();
          $this->jdService->match($orders);
          $this->updateMinusStatus(JdOrderCustomer::MATCHED);
      }
//     public function handle()
//     {
//         $this->updateMinusStatus(JdOrderCustomer::MATCHING);

//         foreach ($this->jdCustomer as $k => $v) {
//             $cusCtModel = CustomerContact::where('phone',$v->tel)->first(['cus_id']);

//             if(!empty($cusCtModel)){

//                 $cusUserl = CustomerUser::where('cus_id',$cusCtModel->cus_id)
//                                     ->first(['user_id','group_id','department_id','cus_id'])->toArray();

//                 $res = JdOrderBasic::where([
//                                 ['order_sn','=',$v->order_sn],
//                                 ['flag','=',$v->flag]
//                             ])->update($cusUserl);

//                 JdOrderCustomer::where('order_sn','=',$v->order_sn)->update(['cus_id'=>$cusCtModel->cus_id]);
                
//                 echo $res;
//             }
//         }

//         $this->updateMinusStatus(JdOrderCustomer::MATCHED);


//     }

    /**
     * [updateMinusStatus 更新状态]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    private function updateMinusStatus($status){
        JdMatchBasic::where('flag','=',$this->flag)->update(['match_status'=>$status]);
    }

    /**
     * 要处理的失败任务。
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        logger("[jdMatchError]", [$exception->getMessage()]);
    }



}
