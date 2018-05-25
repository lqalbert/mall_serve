<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpressCompensation;
use Illuminate\Http\Request;

class ExpressCompensationController extends Controller
{

    private $model = null;
    public function __construct(ExpressCompensation $ExpressCompensation) {
        $this->model = $ExpressCompensation;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($request->has('entrepot_id')) {
            $where['express_compensations.entrepot_id'] = $request->input('entrepot_id');
        }
        if ($request->has('express_id')) {
            $where['express_compensations.express_id'] = $request->input('express_id');
        }
        if ($request->has('order_number')) {
            $where['express_compensations.order_number'] = $request->input('order_number');
        }
        if ($request->has('express_number')) {
            $where['express_compensations.express_number'] = $request->input('express_number');
        }
        $data = $this->model->where($where)
            ->paginate($request->input('pageSize'));
        return ['items' => $data->items(), 'total' => $data->total()];
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
        $data = $request->all ();
        $re = $this->model->create( $data );
        if ($re) {
            return $this->success ( $re );
        } else {
            return $this->error ( 0 );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpressCompensation  $expressCompensation
     * @return \Illuminate\Http\Response
     */
    public function show(ExpressCompensation $expressCompensation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpressCompensation  $expressCompensation
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpressCompensation $expressCompensation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpressCompensation  $expressCompensation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $re=$this->model->where('id',$id)->update($request->all());
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error(0);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpressCompensation  $expressCompensation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re = $this->model->destroy($id);
        if ($re) {
            return $this->success(1);
        } else {
            return $this->error(0);
        }
    }
}
