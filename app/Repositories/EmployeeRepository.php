<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class EmployeeRepository extends Repository
{
    public function  model() 
    {
        return 'App\Models\User';
    }
}