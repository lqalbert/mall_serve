<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class GroupRepository extends Repository
{
    public function  model() 
    {
        return 'App\Models\Group';
    }
}