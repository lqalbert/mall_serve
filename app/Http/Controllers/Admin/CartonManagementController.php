<?php

namespace App\Http\Controllers\Admin;

use App\Models\CartonManagement;
use Illuminate\Http\Request;

class CartonManagementController extends Controller
{

    private $model = null;
    public function __construct(CartonManagement $CartonManagement) {
        $this->model = $CartonManagement;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($request->has('carton_name')) {
            $where['carton_management.carton_name'] = $request->input('carton_name');
        }
        if ($request->has('carton_model')) {
            $where['carton_management.carton_model'] = $request->input('carton_model');
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
        $re = $this->model->create ( $data );
        if ($re) {
            return $this->success ( $re );
        } else {
            return $this->error ( 0 );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartonManagement  $cartonManagement
     * @return \Illuminate\Http\Response
     */
    public function show(CartonManagement $cartonManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartonManagement  $cartonManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(CartonManagement $cartonManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartonManagement  $cartonManagement
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
     * @param  \App\Models\CartonManagement  $cartonManagement
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
