<?php

namespace App\Models;
use App\User;
use App\QueryBuilder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use SoftDeletes, HasFactory;

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
