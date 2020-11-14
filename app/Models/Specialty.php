<?php

namespace App\Models;

use App\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialty extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * @return UserQuery
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
