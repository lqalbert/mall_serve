<?php
namespace  App\Services\Orderlist;

use App\Repositories\OrderlistRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Alg\ModelCollection;
use App\Repositories\Criteria\OrderByIdDesc;
use App\Repositories\Criteria\WhereIn;
use App\Repositories\Criteria\FieldEqual;
use App\Repositories\Criteria\FieldLike;
use App\Repositories\Criteria\NotEqual;
use App\Repositories\Criteria\FieldEqualGreaterThan;
use App\Repositories\Criteria\FieldEqualLessThan;
use App\Repositories\Criteria\Orderlist\AfterSale;
use App\Repositories\Criteria\Orderlist\ExsitsAssign;
class OrderlistService
{
    private $repository = null;

    private $request = null;

    public function  __construct(OrderlistRepository $repository, Request $request)
    {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function get()
    {
        $where = array();
        $whereIn = array();
        if ($this->request->has('refund_id')) {
            $this->refund($this->request->refund_id);
        }
	    if ($this->request->has('id')) {
            // $where[]=['id','=',$this->request->id];
            $this->repository->pushCriteria(new FieldEqual('id', $this->request->id));
        }
        if ($this->request->has('cus_id')) {
            // $where[]=['id','=',$this->request->id];
            $this->repository->pushCriteria(new FieldEqual('cus_id', $this->request->cus_id));
        }
        if ($this->request->has('sn')) {
        	// $where[]=['order_sn','like',$this->request->sn."%"];
            $this->repository->pushCriteria(new FieldLike('order_sn', $this->request->sn));
        }
        if ($this->request->has('order_sn')) {
            // $where[]=['order_sn','=',$this->request->order_sn];
            $this->repository->pushCriteria(new FieldEqual('order_sn', $this->request->order_sn));
        }
        if ($this->request->has('order_pay_money')) {
            // $where[]=['order_pay_money','=',$this->request->order_pay_money];
            $this->repository->pushCriteria(new FieldEqual('order_pay_money', $this->request->order_pay_money));
        }
        if ($this->request->has('goods_name')) {
            $goods = DB::table('goods_basic')
                ->where('goods_name', 'like', $this->request->goods_name."%")
                ->get();
            $ids = array();
            foreach($goods as $v)
            {
                $ids[] = $v->id;
            }
            // $whereIn = $ids;
            if ($ids) {
                $this->repository->pushCriteria(new WhereIn('goods_id', $ids));
            }
        }
        if ($this->request->has('consignee')) {
            $sales = DB::table('order_address')
                ->where('name', 'like', $this->request->input('consignee')."%")
                ->get();
            $cusIds1 = [];
            foreach ($sales as $v){
                $cusIds1[] = $v->cus_id;
            }
        }
        
        if ($this->request->has('phone')) {
            $sales = DB::table('order_address')
            ->where('phone', 'like', $this->request->phone."%")
            ->get();
            $cusIds2 = [];
            foreach ($sales as $v){
                $cusIds2[] = $v->cus_id;//order_id
            }
        }
        
        if($this->request->has('consignee') && !$this->request->has('phone')){
            if (!empty($cusIds1)) {
                $this->repository->pushCriteria(new WhereIn('cus_id', $cusIds1));
            }else{
                $this->repository->pushCriteria(new FieldEqual('cus_id', '0'));
            }
        }

        if(!$this->request->has('consignee') && $this->request->has('phone')){
            if (!empty($cusIds2)) {
                $this->repository->pushCriteria(new WhereIn('cus_id', $cusIds2));
            }else{
                $this->repository->pushCriteria(new FieldEqual('cus_id', '0'));
            }
        }

        if($this->request->has('consignee') && $this->request->has('phone')){
            $cusIds3 = array_intersect($cusIds1,$cusIds2);
            if (!empty($cusIds3)) {
                // echo 1;
                $this->repository->pushCriteria(new WhereIn('cus_id', $cusIds3));
            }else{
                // echo 2;
                $this->repository->pushCriteria(new FieldEqual('cus_id', '0'));
            }
        }
        
        if ($this->request->has('deal_name')) {
            // $where[]=['deal_name','like',"%".$this->request->deal_name."%"];
            $this->repository->pushCriteria(new FieldLike('deal_name', $this->request->deal_name));
        }
        if ($this->request->has('deal_id')) {
            // $where[]=['deal_id','=',$this->request->deal_id];
            $this->repository->pushCriteria(new FieldEqual('deal_id', $this->request->deal_id));
        }
        if ($this->request->has('department_id')) {
            logger("[department_id]",[$this->request->input('department_id')]);
            $this->repository->pushCriteria(new FieldEqual('department_id', $this->request->input('department_id')));
        }
        if ($this->request->has('group_id')) {
            // $where[]=['group_id','=',$this->request->group_id];
            $this->repository->pushCriteria(new FieldEqual('group_id', $this->request->group_id));
        }
        if ($this->request->has('type')) {
            $this->repository->pushCriteria(new FieldEqual('type', $this->request->type));
        }
        if ($this->request->has('deliver')) {
            // $where[]=['shipping_status', '=', $this->request->deliver];
            $this->repository->pushCriteria(new FieldEqual('shipping_status', $this->request->deliver));
        }
        if ($this->request->has('start')) {
            // $where[]=['created_at','>=', $this->request->start];
            $this->repository->pushCriteria(new FieldEqualGreaterThan('created_at', $this->request->start));
        }
        if ($this->request->has('end')) {
            // $where[]=['created_at','<=', $this->request->end];
            $this->repository->pushCriteria(new FieldEqualLessThan('created_at', $this->request->end));
        }
        if ($this->request->has('status')) {
            // $where[]=['status',$this->request->input('status')];
            $this->repository->pushCriteria(new FieldEqual('status', $this->request->status));
        }
        if ($this->request->has('assign_status')) {
            // $where[]=['product_status',$this->request->input('product_status')];
            $this->repository->pushCriteria(new ExsitsAssign());
        }
        if ($this->request->has('product_status')) {
            // $where[]=['product_status',$this->request->input('product_status')];
            $this->repository->pushCriteria(new FieldEqual('product_status', $this->request->product_status));
        }
        if ($this->request->has('after_sale_status')) {
            // $where[]=['after_sale_status','<>',0];
//             $this->repository->pushCriteria(new NotEqual('after_sale_status', $this->request->after_sale_status));
            $this->repository->pushCriteria(new AfterSale());
        }
        
        if (!$this->request->has('orderField')) {
            $this->repository->pushCriteria(new OrderByIdDesc());
        }
        
        if ($this->request->has('with')) {
            $this->repository->with($this->request->input('with'));
        }
        
        $result = $this->repository->paginate($this->request->input('pageSize', 20));
        
        $collection = $result->getCollection();
        if ($this->request->has('appends')) {
            ModelCollection::setAppends($collection, $this->request->input('appends'));
        }
        
//         logger("[debug]", $collection->toArray());
        
        return [
            'items'=> $collection,
            'total'=> $result->total()
        ];
    }
    /**
     *
     * 发起退款
     * @param $status
     * @return array
     */
    public function refund($refund_id){
        $data = array(
            'refund_status' => '1',
            'order_status'  => '4',
            'refund_check' => '0',
            'check_status' => '0'
        );
        if($refund_id)
        {
            DB::table('order_basic')
                ->where('id', $refund_id)
                ->update($data);
        }

    }
    public function get_order_status($status){
        $status = app()->makeWith('App\Repositories\Criteria\Orderlist\Order_status', ['status'=>$status]);
        $this->repository->pushCriteria($status);
        $result = $this->repository->paginate();
        return [
            'items'=> $result->getCollection(),
            'total'=> $result->total()
        ];
    }
    public function get_deliver_status($status){
        $status = app()->makeWith('App\Repositories\Criteria\Orderlist\Deliver_status', ['status'=>$status]);
        $this->repository->pushCriteria($status);
        $result = $this->repository->paginate();
        return [
            'items'=> $result->getCollection(),
            'total'=> $result->total()
        ];
    }
}
