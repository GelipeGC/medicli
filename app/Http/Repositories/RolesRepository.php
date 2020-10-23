<?php

namespace App\Http\Repositories;

use App\Http\Support\GeneralTrait;
use Spatie\Permission\Models\Role;
use App\Http\Support\JsonResponseTrait;
use Illuminate\Database\QueryException;

class RolesRepository
{
    use GeneralTrait, JsonResponseTrait;
    
    protected $model;

    /**
     * RolesRepository constructor
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * Store a newly create user in database
     * 
     * @param $array $data
     * @return json $json
     */
    public function create(array $data)
    {
        try {
            $role = new $this->model();
            $role->name = $this->ucfirst($data['name']);

            if ($role->save()) {
                return $this->sendSuccessfullyResponse('success', trans('roles.create'), 201, $role);
            }
            return $this->sendFailedResponse('success', trans('roles.failed', 500));
        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), 500);
        }
    }
}