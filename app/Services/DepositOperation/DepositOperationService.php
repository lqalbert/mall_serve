<?php
namespace App\Services\DepositOperation;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\models\OrderBasic;
use App\Models\User;
use App\Models\DepositOperationLog;
use App\Models\Department;
use App\Models\Deposit;

class DepositOperationService{

	private $operationModel;

	public function __construct(Deposit $model ){
	    $this->log = $model;
	}

	/**
	 * [depositAttributes 设置保证金模型属性]
	 * @param  User       $user       [description]
	 * @param  OrderBasic $orderModel [description]
	 * @param  [type]     $action     [description]
	 * @return [type]                 [description]
	 */
// 	private function depositLogAttributes(User $user,OrderBasic $orderModel,$action){
// 		$this->operationModel->operator_id = $user->id;
//         $this->operationModel->operator = $user->realname;
//         $this->operationModel->order_id = $orderModel->id;
//         $this->operationModel->department_id = $orderModel->department->id;
//         $this->operationModel->action = $action;
// 	}

	/**
	 * [depositLog 保证金日志]
	 * @param  User       $user       [description]
	 * @param  OrderBasic $orderModel [description]
	 * @param  string     $action     [description]
	 * @return [type]                 [description]
	 */
// 	public function depositLog(User $user,OrderBasic $orderModel,$action=''){
// 		DB::beginTransaction();
// 		try {
// 			$this->depositLogAttributes($user,$orderModel,$action);

//         	$order_sn = $orderModel->order_sn;
// 	        $department_name = $orderModel->department->name;
// 	        $money = $orderModel->order_pay_money;
// 	        switch ($action) {
// 	            case 'cancel':
// 	                $this->operationModel->remark = "订单".$order_sn."，部门".$department_name.'保证金+'.$money;
// 	                break;
// 	            case 'check':
// 	                $this->operationModel->remark = "订单".$order_sn."，部门".$department_name.'保证金-'.$money;
// 	                break;
// 	            default:
// 	                # code...
// 	                break;
// 	        }

// 	        if (!$this->operationModel->save()) {
// 	            throw new \Exception('订单保证金日志记录失败');
// 	        }
// 	        DB::commit();
// 		} catch (\Exception $e) {
// 			DB::rollback();
// 			throw new \Exception($e->getMessage());
// 		}
// 	}

	/**
	 * [addDeposit 添加保证金]
	 * @param Department $department [description]
	 * @param [type]     $money      [description]
	 */
	public function addDeposit(Department $department, $money, $remark=null){
		DB::beginTransaction();
		try {
			$department->addDeposit($money);
			$re = $department->save();
			if(!$re){
				throw new \Exception('部门保证金添加失败');
			}
			$this->log->fill([
			   'department_id'=> $department->id,
			   'department_name'=> $department->name,
			   'money' => $money,
			   'creator_id' => auth()->user()->id,
			   'creator' => auth()->user()->realname,
			    'action_type' =>  Deposit::ADD,
			    'remark' => $remark
			]);
			$re = $this->log->save();
			if(!$re){
			    throw new \Exception('部门保证金添加失败:日志失败');
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			throw new \Exception($e->getMessage());
		}

	}
	
	/**
	 * [addDeposit 返还保证金]
	 * @param Department $department [description]
	 * @param [type]     $money      [description]
	 */
	public function returnDeposit(Department $department, $money){
	    DB::beginTransaction();
		try {
			$department->addDeposit($money);
			$re = $department->save();
			if(!$re){
				throw new \Exception('部门保证金返还失败');
			}
			$this->log->fill([
			    'department_id'=> $department->id,
			    'department_name'=> $department->name,
			    'money' => $money,
			    'creator_id' => auth()->user()->id,
			    'creator' => auth()->user()->realname,
			    'action_type' =>  Deposit::TYPE_RETURN
			]);
			$re = $this->log->save();
			if(!$re){
			    throw new \Exception('部门保证金返还失败:日志失败');
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			throw new \Exception($e->getMessage());
		}

	}

	/**
	 * [subDeposit 扣除保证金]
	 * @param  Department $department [description]
	 * @param  [type]     $money      [description]
	 * @return [type]                 [description]
	 */
	public function subDeposit(Department $department,$money){
	    DB::beginTransaction();
		try {
			$department->subDeposit($money);
			
			if ($department->isNegative()) {
			    throw new \Exception('部门保证金余额不足');
			}
			$re = $department->save();
			if(!$re){
				throw new \Exception('部门保证金扣除失败');
			}
			
			$this->log->fill([
			    'department_id'=> $department->id,
			    'department_name'=> $department->name,
			    'money' => $money,
			    'creator_id' => auth()->user()->id,
			    'creator' => auth()->user()->realname,
			    'action_type' =>  Deposit::DEDUCTION
			]);
			$re = $this->log->save();
			if(!$re){
			    throw new \Exception('部门保证金扣除失败:日志失败');
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			throw new \Exception($e->getMessage());
		}
	}






}