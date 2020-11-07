<?php

namespace App\Models;
use App\User;
use App\QueryBuilder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends \Spatie\Permission\Models\Role
{
    use SoftDeletes;

    public $guard_name = 'api';
    /**
     * @return RoleQuery
     */
    public static function query()
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new QueryBuilder($query);
    }
    

}
