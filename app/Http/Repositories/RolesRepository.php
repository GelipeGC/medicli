<?php

namespace App\Http\Repositories;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use App\Http\Support\GeneralTrait;
use App\Http\Resources\RoleResource;
use App\Http\Support\JsonResponseTrait;
use Illuminate\Database\QueryException;

class RolesRepository
{
    use GeneralTrait, JsonResponseTrait;
    
    protected $model;
    const ITEM_PER_PAGE = 10;

    /**
     * RolesRepository constructor
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }
    /**
     * Display a listing of the resource and apply filters by specialties
     * @return \Illuminate\Http\Response
     */
    public function all($request)
    {
        return $this->model::query()
                        ->applyFilters()
                        ->orderByDesc('created_at')
                        ->paginate(static::ITEM_PER_PAGE);
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
                return $this->sendSuccessfullyResponse('success', trans('roles.create'), JsonResponse::HTTP_CREATED,new RoleResource($role));
            }
            return $this->sendFailedResponse('success', trans('roles.failed', JsonResponse::HTTP_INTERNAL_SERVER_ERROR));
        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update($data, $id)
    {
        try {
            $role = $this->model::find($id);

            if (is_null($role)) {
                return $this->sendFailedResponse('success', trans('roles.exists'), JsonResponse::HTTP_NOT_FOUND);
            }

            $role->name = $data['name'];
            if ($role->update()) {
                return $this->sendSuccessfullyResponse('success', trans('roles.update'), JsonResponse::HTTP_CREATED, new RoleResource($role));
            }
            return $this->sendFailedResponse('success', trans('roles.failed'), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function delete($id)
    {
        try {
            $role = $this->model::find($id);

            if (is_null($role)) {
                return $this->sendFailedResponse('success', trans('roles.exists'), JsonResponse::HTTP_NOT_FOUND);
            }
            
            if (count($role->users)) {
                return $this->sendFailedResponse('success', trans('roles.relation'), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($role->delete()) {
                return $this->sendSuccessfullyResponse('success', trans('roles.delete'), JsonResponse::HTTP_OK);
            }
            return $this->sendFailedResponse('success', trans('roles.failed'), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);

        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}