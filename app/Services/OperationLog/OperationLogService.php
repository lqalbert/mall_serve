<?php
namespace App\Services\OperationLog;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\models\OrderBasic;
use App\Models\User;
use App\Models\DepositOperationLog;

class OperationLogService{

	private $operationModel;

	public function __construct(DepositOperationLog $operation){
		$this->operationModel = $operation;
	}

	/**
	 * [depositAttributes 设置保证金模型属性]
	 * @param  User       $user       [description]
	 * @param  OrderBasic $orderModel [description]
	 * @param  [type]     $action     [description]
	 * @return [type]                 [description]
	 */
	private function depositAttributes(User $user,OrderBasic $orderModel,$action){
		$this->operationModel->operator_id = $user->id;
        $this->operationModel->operator = $user->realname;
        $this->operationModel->order_id = $orderModel->id;
        $this->operationModel->department_id = $orderModel->department->id;
        $this->operationModel->action = $action;
	}

	/**
	 * [depositLog 保证金日志]
	 * @param  User       $user       [description]
	 * @param  OrderBasic $orderModel [description]
	 * @param  string     $action     [description]
	 * @return [type]                 [description]
	 */
	public function depositLog(User $user,OrderBasic $orderModel,$action=''){
		DB::beginTransaction();
		try {
			$this->depositAttributes($user,$orderModel,$action);

        	$order_sn = $orderModel->order_sn;
	        $department_name = $orderModel->department->name;
	        $money = $orderModel->order_pay_money;
	        switch ($action) {
	            case 'cancel':
	                $this->operationModel->remark = "订单".$order_sn."，部门".$department_name.'保证金+'.$money;
	                break;
	            case 'check':
	                $this->operationModel->remark = "订单".$order_sn."，部门".$department_name.'保证金-'.$money;
	                break;
	            default:
	                # code...
	                break;
	        }

	        if (!$this->operationModel->save()) {
	            throw new \Exception('订单保证金日志记录失败');
	        }
	        DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			throw new \Exception($e->getMessage());
		}
	

	}









}