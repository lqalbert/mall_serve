<?php
namespace App\Services\Customer;


use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use App\Alg\ModelCollection;
use App\Models\CustomerBasic;
use App\Models\CustomerContact;
class CustomerService
{
    private $repository = null;
    private $request = null;
    private $customer_basic = null;
    private $customer_contact = null;
    
    public function  __construct(CustomerRepository $repository,CustomerBasic $customerBasic,CustomerContact $customerContact ,Request $request) 
    {
        $this->repository = $repository;
        $this->request = $request;
        $this->customer_basic = $customerBasic;
        $this->customer_contact = $customerContact;
    }
    
    public function  get()
    {

//        $selectFields = ['id','name','type','sex','recommend'];
        $selectFields = ['id','name','age','sex',];
        $result = $this->repository
                        ->with(['contacts'])
                        ->paginate($this->request->input('pageSize', 20),$selectFields);
//        $appends = ['type_text', 'sex_text'];
//        $collection = ModelCollection::setAppends($result->getCollection(), $appends);
        return  [
            'items'=> $result->getCollection(),
            'total'=> $result->total()
        ];
    }
    public  function  getData(){

        $where=[];
        if($this->request->has('name')){
            $where['customer_basic.name']=$this->request->name;
        }
        if($this->request->has('phone')){
            $where['customer_contact.phone']=$this->request->phone;
        }
        $result= $this->customer_basic
            ->join('customer_contact','customer_basic.id','=','customer_contact.cus_id')
            ->where($where)
            ->whereNull('customer_basic.deleted_at')
            ->whereNull('customer_contact.deleted_at')
            ->get();
        $count= $this->customer_basic
            ->join('customer_contact','customer_basic.id','=','customer_contact.cus_id')
            ->where($where)
            ->whereNull('customer_basic.deleted_at')
            ->whereNull('customer_contact.deleted_at')
            ->count();
        return [
            'items'=>$result,
            'total'=>$count
        ];
    }

    public function storeData()
    {
        
        $this->customer_basic->name = $this->request->name;
        $this->customer_basic->sex = $this->request->sex;
        $this->customer_basic->age = $this->request->age;
        $this->customer_basic->save();
        $cis_id=$this->customer_basic->id;
        $this->customer_contact->cus_id=$cis_id;
        $this->customer_contact->phone=$this->request->phone;
        $this->customer_contact->qq=$this->request->qq;
        $this->customer_contact->qq_nickname=$this->request->qq_nickname;
        $this->customer_contact->weixin=$this->request->weixin;
        $this->customer_contact->weixin_nickname=$this->request->weixin_nickname;
        $this->customer_contact->save();
    }

    public function upDate($id)
    {

        $updata1=[
            'name'=>$this->request->name,
            'age'=>$this->request->age,
            'sex'=>$this->request->sex,
        ];
        $updata2=[
            'phone'=>$this->request->phone,
            'weixin'=>$this->request->weixin,
            'weixin_nickname'=>$this->request->weixin_nickname,
            'qq'=>$this->request->qq,
            'qq_nickname'=>$this->request->qq_nickname,
        ];
        $this->customer_basic->where('id','=',$id)->update($updata1);
        $this->customer_contact->where('cus_id','=',$id)->update($updata2);
    }

    public function destroyData($id)
    {
        $this->customer_basic->destroy($id);
        $this->customer_contact->where('cus_id','=',$id)->delete();
    }
}