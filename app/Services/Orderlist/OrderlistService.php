<?php
namespace  App\Services\Orderlist;

use App\Repositories\OrderlistRepository;
use Illuminate\Http\Request;

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
        if ($this->request->has('order_sn')) {
            $order_sn = app()->makeWith('App\Repositories\Criteria\Orderlist\Ordersn', ['order_sn'=>$this->request->order_sn]);
            $this->repository->pushCriteria($order_sn);
        }
        if ($this->request->has('goods_name')) {
            $goods_name = app()->makeWith('App\Repositories\Criteria\Orderlist\Goodsname', ['goods_name'=>$this->request->goods_name]);
            $this->repository->pushCriteria($goods_name);
        }
        if ($this->request->has('consignee')) {
            $consignee = app()->makeWith('App\Repositories\Criteria\Orderlist\Consignee', ['consignee'=>$this->request->consignee]);
            $this->repository->pushCriteria($consignee);
        }
        if ($this->request->has('type')) {
           $order_status=  app()->makeWith('App\Repositories\Criteria\Orderlist\OrderStatus', ['status'=>$this->request->type]);
           $this->repository->pushCriteria($order_status);
        }
        if ($this->request->has('deliver')) {
            $deliver= app()->makeWith('App\Repositories\Criteria\Orderlist\Deliver', ['deliver'=>$this->request->deliver]);
            $this->repository->pushCriteria($deliver);
        }
        if ($this->request->has('start')) {
            $order_status=  app()->makeWith('App\Repositories\Criteria\Orderlist\Starttime', ['start_time'=>$this->request->start]);
            $this->repository->pushCriteria($order_status);
        }
        if ($this->request->has('end')) {
            $order_status=  app()->makeWith('App\Repositories\Criteria\Orderlist\Endtime', ['end_time'=>$this->request->end]);
            $this->repository->pushCriteria($order_status);
        }
        $result = $this->repository->paginate();
        return [
            'items'=> $result->getCollection(),
            'total'=> $result->total()
        ];
        //下面的参考一下。字段没加全
//         return [
//             'items'=>[
//                 [
//                     'id'=> 1,
//                     'account'=> 'gfsdg',
//                     'realname'=> 'gsggs',
//                     'department_name'=>'hdfhd',
//                     'head'=>'gdfg',
//                     'qq'=> 'gdfh',
//                     'role'=> 'ndfhdf',
//                     'sex'=> '男' || '女',
//                     'phone'=> '132465465',
//                     'mphone'=> '23131',
//                     'remark'=>'hdghdf',
//                     'status'=>'hdfhd',
//                     'id_card'=>'dfjkhg',
//                     'qq_nickname'=>'fghdf',
//                     'weixin'=>'jfdj',
//                     'weixin_nikname'=>'kldfhgkdf',
//                     'address'=>'jfgjf',
//                     'ip'=>'192.168.0.10',
//                     'location'=>'ohigfdgjk',
//                     'lg_time'=>'2017-12-02',
//                     'out_time'=>'2017-12-02',
//                     'created_at'=>'2017-12-02',
//                     'creator'=>'fjkgjkf',
//                 ]
//             ],
//             'total'=>400
//         ];
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