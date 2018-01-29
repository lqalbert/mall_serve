<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\GoodsSpecs;
use App\Repositories\GoodsSpecsRepository;
class GoodsSpecsController extends Controller
{

    private $repository = null;
    public function  __construct(GoodsSpecsRepository $goodsSpecsRepository) 
    {
        $this->repository = $goodsSpecsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $re = $this->repository->paginate(10);
        return [
        		'items' => $re->items(),
        		'total' => $re->total()
        ];
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
        $re = $this->repository->create($request->all());
        if ($re) {
        	return $this->success($re);
        } else {
        	return $this->error();
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
    	$re = $this->repository->update($request->all(), $id);
    	if ($re) {
    		return $this->success($re);
    	} else {
    		return $this->error();
    	}
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //返回 int
        $re = $this->repository->delete($id);
        if ($re) {
            //return $this->success(1);
            return 1;
        } else {
            //return $this->error();
            return 2;
        }
    }
}
