<?php
namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IdDesc implements Scope
{
    
    public function apply(Builder $builder, Model $model)
    {
        return $builder->orderBy('id','desc');
    }
}