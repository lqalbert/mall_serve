<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FreightExtra;

class FreightExtraController extends Controller
{
    private $model = null;
    public function __construct(FreightExtra $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('fr_id')) {
            $this->model = $this->model->where('fr_id',$request->input('fr_id'));
        }
        
        if ($request->has('province_id')) {
            $this->model = $this->model->where('province_id',$request->input('province_id'));
        }
        
        if ($request->has('with')) {
            $this->model = $this->model->with($request->input('with'));
        }
        
        $result  = $this->model->paginate($request->input('pageSize',20));
        return [
            'items' => $result->items(),
            'total' => $result->total()
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
        $re = $this->model->create($request->all());
        if ($re) {
            return $this->success([]);
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
        //update 返回 bool
        $re = $this->model->where('id', $id)->update($request->all());
        if ($re) {
            return $this->success([]);
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
            return $this->error([]);
        }
    }
}
