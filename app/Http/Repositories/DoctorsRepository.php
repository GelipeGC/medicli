<?php

namespace App\Http\Repositories;

use App\User;
use App\Http\Resources\DoctorResource;
use App\Http\Support\JsonResponseTrait;

class DoctorsRepository
{
    use JsonResponseTrait;
    const ITEM_PER_PAGE = 10;
    protected $model;
    /**
     * DoctorsRepository constructor
     * 
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function create(array $data)
    {
        try {
            $doctor = new $this->model();
            $doctor->name = $data['name'];
            $doctor->email = $data['email'];
            $doctor->address = $data['address'];
            $doctor->phone = $data['phone'];

            if ($doctor->save()) {
                return $this->sendSuccessfullyResponse('success', trans('doctors.create'), 201, new DoctorResource($doctor));
            }
            return $this->sendFailedResponse('success', trans('doctors.failed'), 500);

        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), 500);
        }
    }
}