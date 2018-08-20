<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CustomerContact;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Events\ContactConflict;
use App\Models\CustomerTrackLog;

class CustomerContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = $request->query('business', 'default');
        $result = [];
        switch ($business) {
            case 'theCus':
                $cus_id = $request->input('cus_id');
                $result = CustomerContact::where('cus_id','=',$cus_id)->get();
                break;
            default:
                $result = CustomerContact::get();
                break;
        }
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
        $user = auth()->user();
        try {
            $this->validate($request, [
                'phone' => ['nullable','unique:customer_contact'],
                'qq' => ['nullable','unique:customer_contact'],
                'weixin' => ['nullable','unique:customer_contact'],
            ]);
        } catch (ValidationException $e) {
            $phone = $request->input('phone');
            $data = [];
            $data['cus_id'] = DB::table('customer_contact')->where('phone',$phone)->value('cus_id');
            $data['cus_name'] = DB::table('customer_basic')->where('id',$data['cus_id'])->value('name');
            $data['user_id'] = $user->toArray()['id'];
            $data['user_name'] = $user->toArray()['realname'];
            $data['content'] = '添加联系方式时与手机号码'.$phone.'冲突';
            $re = CustomerTrackLog::create($data);
            if($re){
                event( new ContactConflict($e->validator->errors(), $request->only(['phone','qq','weixin'])));
                throw $e;
            }

        }
        
        
       
        
        $model = CustomerContact::create($request->all());
        if($model){
            return $this->success($model);
        }else{
            return $this->error($model);
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
        try {
            logger('[me]', ['a', $id]);
            $this->validate($request, [
                'phone' =>  ['bail','nullable',  Rule::unique('customer_contact')->ignore($id)],
                'qq'    =>  ['bail','nullable',  Rule::unique('customer_contact')->ignore($id)],
                'weixin' => ['bail','nullable',  Rule::unique('customer_contact')->ignore($id)],
            ]);
            logger('[me]', ['b']);
        } catch (ValidationException $e) {
            event( new ContactConflict($e->validator->errors(), $request->only(['phone','qq','weixin'])));
            throw $e;
        }
        // var_dump($request->all());
        $model = CustomerContact::where('id','=',$id)->update($request->all());
        if($model){
            return $this->success($model);
        }else{
            return $this->error($model);
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
        $re = CustomerContact::destroy($id);
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error($re);
        }
    }
}
