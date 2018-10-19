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

class JdOrderMatchUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $jdCustomer;
    private $flag;
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        JdMatchBasic::where('flag','=',$this->flag)->update(['match_status'=>1]);

        foreach ($this->jdCustomer as $k => $v) {
            $cusCtModel = CustomerContact::where('phone',$v->tel)->first(['cus_id']);
            // var_dump($cusCtModel);
            if(!empty($cusCtModel)){
                // echo $cusCtModel->cus_id;
                $cusUserl = CustomerUser::where('cus_id',$cusCtModel->cus_id)
                                    ->first(['user_id','group_id','department_id'])->toArray();
                // echo 'order_sn'.$v->order_sn;
                // echo 'flag'.$v->flag;
                $res = JdOrderBasic::where([
                                ['order_sn','=',$v->order_sn],
                                ['flag','=',$v->flag]
                            ])->update($cusUserl);
                echo $res;
            }
        }

        JdMatchBasic::where('flag','=',$this->flag)->update(['match_status'=>2]);


    }

    /**
     * 要处理的失败任务。
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        logger("[queueErr]", $exception->getMessage());
    }



}
