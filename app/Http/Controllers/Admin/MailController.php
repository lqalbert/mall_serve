<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public $model = null;

    public function __construct(Mail $mail)
    {
        $this->model = $mail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($request->has('start')) {
            $where[]=['created_at','>=',$request->input('start').' 00:00:00'];
        }
        if ($request->has('end')) {
            $where[]=['created_at','<=',$request->input('end').' 23:59:59'];
        }
        if ($request->has('type')) {
            $where[]=['type','=',$request->input('type')];
        }
        if ($request->has('express_sn')) {
            $where[]=['express_sn','=',$request->input('express_sn')];
        }
        $data = $this->model->where($where)
            ->orderBy('created_at', 'desc')
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
        // DD($data);
        $re = $this->model->create ( $data );
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function show(mail $mail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $re = $this->model->where('id','=',$id)->update($request->all());
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $re =  $this->model->destroy($id);
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
    }
}
