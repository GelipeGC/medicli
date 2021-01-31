<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Support\GeneralTrait;
use App\Http\Resources\DoctorResource;
use App\Http\Support\JsonResponseTrait;

class DoctorsRepository
{
    use JsonResponseTrait, GeneralTrait;
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
    /**
     * Display a listing of the resource and apply filters by users.
     *
     * @return \Illuminate\Http\Response
     */
    public function all($request)
    {
        return $this->model::query()
                            ->select(['id','name','phone','email','created_at'])
                            ->onlyDoctors()
                            ->applyFilters()
                            ->orderByDesc('created_at')
                            ->paginate(10);
    }
    public function create(array $data)
    {
        try {
            $doctor = new $this->model();
            $doctor->name = $this->initCap($data['name']);
            $doctor->email = Str::lower($data['email']);
            $doctor->address = $data['address'];
            $doctor->phone = $data['phone'];

            if ($doctor->save()) {
                $doctor->assignRole($data['role_id']);
                return $this->sendSuccessfullyResponse('success', trans('doctors.create'), 201, new DoctorResource($doctor));
            }
            return $this->sendFailedResponse('success', trans('doctors.failed'), 500);

        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), 500);
        }
    }
    public function update(array $data, int $id)
    {
        try {
            $user = $this->model::findOrFail($id);
            $user->name = $this->initCap($data['name']);
            $user->email = Str::lower($data['email']);
            $user->phone = $data['phone'];
            $user->address = $data['address'];
            if ($user->update()) {

                return $this->sendSuccessfullyResponse('success',trans('doctors.update'),201,$user);
            }
            return $this->sendFailedResponse('success',trans('doctors.failed'), 500);

        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), 500);

        }
    }
    /**
     * Remove the specified user in database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = $this->model::findOrFail($id);

        if ($user->status == $this->model::ACTIVE) {
            return $this->sendFailedResponse('success', trans('doctors.failed'), 403);
        }


        if ($user->delete()) {
            return $this->sendSuccessfullyResponse('success', trans('doctors.delete'), 200);
        }
        return $this->sendFailedResponse('success', trans('doctors.failed'), 500);
    }
}

