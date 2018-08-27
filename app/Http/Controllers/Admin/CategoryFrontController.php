<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryFront;

class CategoryFrontController extends Controller
{
    private $model = null;
    
    public function __construct(CategoryFront $model)
    {
        $this->model = $model;   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //暂不加条件
        
        $cates = $this->model->get();
        $cates_arr = $cates->keyBy('id')->toArray();
        
        $cates_arr[0] = [];
        foreach ($cates_arr as  $item) {
            if (isset($item['pid']) && isset($cates_arr[$item['pid']])) {
                $parentId = $item['pid'];
                if (!isset($cates_arr[$parentId]['children'])) {
                    $cates_arr[$parentId]['children'] = [];
                }
                $cates_arr[$parentId]['children'][] = &$cates_arr[$item['id']];
            }
        }

        return [
            'items'=>$cates_arr[0]['children'],
            'total'=>0
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $re = $this->model->create($request->all());
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error([]);
        }
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
        $re = $this->model->where('id', $id)->update($request->all());
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error([]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re = $this->model->destroy($id);
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error();
        }
    }
}
