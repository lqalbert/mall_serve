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

    public function  get()
    {
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
}