<?php

namespace App\Models\Queries;

use App\Models\Role;
use Fguzman\QueryBuilder;

class UserQuery extends QueryBuilder
{
    public function findByEmail($email)
    {
        return $this->where(compact('email'))->first();
    }

    public function onlyDoctors()
    {
        $this->whereHas('roles', function($q) {
            $q->where('name', 'Doctor');
        });

        return $this;
    }
}

