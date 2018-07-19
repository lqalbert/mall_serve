<?php
namespace App\Services\Ordergoods;

use App\Repositories\OrdergoodsRepository;
use Illuminate\Http\Request;
use App\Repositories\Criteria\Ordergoods\Ordergoods;
use App\Repositories\Criteria\FieldEqual;
use App\Repositories\Criteria\Ordergoods\Enterpot;
use App\Repositories\Criteria\Ordergoods\DateRange;
use App\Alg\ModelCollection;
use App\Models\Assign;
class OrdergoodsService
{
    /**
     * department 资源库
     * @var unknown
     */
    private $repository = null;

    private $request = null;

    public function  __construct(OrdergoodsRepository $departRepository, Request $request)
    {
        $this->repository = $departRepository;
        $this->request = $request;
    }


    public function  get()
    {
        $where = array();
        $whereIn = array();
        if ($this->request->has('goods_id')&&$this->request->has('order_id')) {
            $goods_id = explode(',',$this->request->goods_id);
            $where[] = ['order_id','=',$this->request->order_id];
            $whereIn[]=$goods_id;
        }

        if($this->request->has('order_id')){
            $where[] = ['order_id','=',$this->request->order_id];
        }
        
        if($this->request->has('assign_id')){
            $where[] = ['assign_id','=',$this->request->assign_id];
        }

        if(count($whereIn)>0 || count($where)>0){
            $order_status=  app()->makeWith('App\Repositories\Criteria\Ordergoods\Ordergoods', ['where'=>$where,'whereIn'=>$whereIn]);
            $this->repository->pushCriteria($order_status);
        }
        
        if ($this->request->has('sku_sn')) {
            $this->repository->pushCriteria(new FieldEqual('sku_sn', $this->request->input('sku_sn')));
        }
        
        if ($this->request->has('entrepot_id')) {
            $this->repository->pushCriteria(new Enterpot($this->request->input('entrepot_id')));
        }
        
        if ($this->request->has('start') && $this->request->has('end')) {
            $range= [];
            $range[] = $this->request->input('start');
            $range[] = $this->request->input('end');
            $this->repository->pushCriteria(new DateRange($range));
        } 
        
        if ($this->request->has('with')) {
            $this->repository->with($this->request->input('with'));
        }
        
        $result = $this->repository->paginate();
        $collection = $result->getCollection();
        
        if ($this->request->has('appends')) {
            ModelCollection::setAppends($collection, $this->request->input('appends'));
        }
        
        
        if ($this->request->has('load')) {
            $collection->load($this->request->input('load'));
            if (in_array('order', $this->request->input('load'))) {
                $collection->each(function($item){
                    $item['order']->setAppends(['status_text']);
                });
            }
            
        }
        
        $items = $collection->toArray();

        if($this->request->has('assign_id')){
            $assign_data = Assign::find($this->request->assign_id)->toArray();
            $goods_numbers= array_column($items,'goods_number');
            $weights= array_column($items,'weight');
            $input_data = [];
            $total_goods_number =0;
            $total_weight =0;
            foreach ($goods_numbers as $v){
                $total_goods_number += $v;
            }
            foreach ($weights as $v){
                $total_weight += $v;
            }
            $input_data['goods_id']='汇总';
            $input_data['price']='汇总';
            $input_data['assign_fee']='汇总';
            $input_data['goods_name'] = $assign_data ? $assign_data['express_name'].':运单号'.$assign_data['express_sn'] : '汇总';
            $input_data['goods_number']=$total_goods_number;
            $input_data['weight']=$total_weight;
            array_unshift($items,$input_data);

        }



        return [
            'items'=> $items,
            'total'=> $result->total()
        ];
    }
}
