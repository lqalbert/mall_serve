<?php
namespace App\Services\GoodsDetails;

use App\Repositories\GoodsDetailsRepository;
use Illuminate\Http\Request;

class GoodsDetailsService{

    /**
     * department 资源库
     * @var unknown
     */
    private $repository = null;
    
    private $request = null;
    
    public function  __construct(GoodsDetailsRepository $goodsDetailsRepository, Request $request) 
    {
        $this->repository = $goodsDetailsRepository;
        $this->request = $request;
    }


    public function  get() 
    {
 
        $result = $this->repository->paginate();
        return [
            'items'=> $result->getCollection(),
            'totle'=> $result->total()
        ]; 
    }

	  
    /**
    * [setEndTime 设置查询时间段结束]
    */
    protected function setEndTime(){
        $end = $this->request->end;
        $today = Date('Y-m-d');
        if($end >=  $today){
          $end = Date('Y-m-d H:i:s', strtotime($today) + 86400);
        }else{
          $end = Date('Y-m-d H:i:s', strtotime($end) + 86400);
        }
        return $end;
    }



}