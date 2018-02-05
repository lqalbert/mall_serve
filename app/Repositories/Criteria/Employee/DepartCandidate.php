<?php
namespace App\Repositories\Criteria\Employee;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use App\Models\Role;
use App\Models\Department;

class DepartCandidate extends Criteria
{
	private $id = 0;
	public function __construct($id = 0)
	{
		$this->id = $id;
	}
	
	/**
	 * @todo department-manager 改成常量
	 * {@inheritDoc}
	 * @see \Bosnadev\Repositories\Criteria\Criteria::apply()
	 */
	public function apply($model, RepositoryInterface $repository)
	{

		$role_id = Role::withoutGlobalScope('hide')->where('name', 'department-manager')->value('id');
		if ($role_id) {
			$roleids = [$role_id];
			$model = $model->whereHas('midRole', function($query)use($roleids){
				$query->whereIn('role_id', $roleids);
			});
		}
		
		$manager_ids = Department::where('manager_id','<>',0)->whereNotNull('manager_id')->pluck('manager_id');
		if ($manager_ids) {
			$model->whereNotIn('id', $manager_ids);
		}
// 		$model->where('department_id',0);
		
		if (!empty($this->id)) {
			$id = $this->id;
			$model =  $model->orWhere(function ($query) use($id) {
				$query->where('id', $id);
			});
		}
		//如果出了bug就用下面的方式试一下
// 		$model->where(function($query) use ($roleIds){
			
// 			$query->whereHas('midRole', function($query)use($roleIds){
// 				$quer->whereIn('role_id', $roleids);
// 			})->where('department_id', 0);
// 		});
		
		return $model;
	}
}