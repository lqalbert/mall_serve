<?php
namespace App\Services\GoodsDetails;

use App\Repositories\GoodsDetailsRepository;
use Illuminate\Http\Request;
use App\Alg\ModelCollection;
use App\Repositories\Criteria\Goods\Name;
use App\Repositories\Criteria\Goods\Categories;

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

        if ($this->request->has('goods_name')) {
            $this->repository->pushCriteria( new Name($this->request->input('goods_name')));
        }

        if ($this->request->has('cate_id')) {
            $this->repository->pushCriteria( new Categories($this->request->input('cate_id')));
        }


        $result = $this->repository->paginate();

        $collection = $result->getCollection();

//         $collection = ModelCollection::setAppends($collection, ['imgs']);
        $goodsInfo=[];
        foreach ($collection as &$model) {
            $model->imgs;
            $model->category;
            $goodsInfo[$model->id]=$model;
        }

        return [
            'items'=> $collection,
            'goods'=> $goodsInfo,
            'total'=> $result->total()
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