<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\AssignRepository;
use App\Repositories\Criteria\FieldEqual;
use App\Repositories\Criteria\FieldLike;
use App\Alg\ModelCollection;

class AssignController extends Controller
{
    private $repository = null;
    
    private $fieldEqual = [
        'entrepot_id',
        'cate_type_id', //大分类,
        'cate_kind_id', //小分类
        'status',//发货状态
        'assign_type', //发货类型 正常、退货、换货
    ];
    
    private $fieldLike = [
        'goods_name',
        'sale_name',
        'deliver_name',
        'deliver_phone',
        'express_name',
        'user_name'
    ];
    
    public function __construct(AssignRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        foreach ($this->fieldEqual as  $value) {
            if ($request->has($value)) {
                $this->repository->pushCriteria(new FieldEqual($value, $request->input($value)));
            }
        }
        
        foreach ($this->fieldLike as  $value) {
            if ($request->has($value)) {
                $this->repository->pushCriteria(new FieldLike($value, $request->input($value)));
            }
        }
        
//         if ($request->has('with')) {
//             $with  = $request->input('with', []);
//             foreach ($with as $model) {
//                 if ($model == 'order') {
//                     $this->repository->with([$model=>function($query){
//                         $query->select('created_at');
//                     }]);
//                 }
//             }
//         }
        
        $pager = $this->repository->paginate($request->input('pageSize', 30), $request->input('fields',['*']));
        
        if ($request->has('appends')) {
            $collection = ModelCollection::setAppends($pager->getCollection(), $request->input('appends'));
        } else {
            $collection = $pager->getCollection();
        }
        
        if ($request->has('with')) {
            $with  = $request->input('with', []);
            foreach ($with as $model) {
                if ($model == 'order') {
                    $collection->load([$model=> function($query){
                        $query->select('created_at');
                    }]);
                }
            }
        }
        
        $result = [
            'items' => $collection,
            'total' => $pager->total()
        ];
        
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $re = $this->repository->update($request->all(), $id);
        return $this->success($re);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
