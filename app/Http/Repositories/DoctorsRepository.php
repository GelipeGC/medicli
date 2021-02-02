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
     * @param User $doctor
     */
    public function __construct(User $doctor)
    {
        $this->model = $doctor;
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
                            ->paginate(static::ITEM_PER_PAGE);
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
            $doctor = $this->model::findOrFail($id);
            $doctor->name = $this->initCap($data['name']);
            $doctor->email = Str::lower($data['email']);
            $doctor->phone = $data['phone'];
            $doctor->address = $data['address'];
            if ($doctor->update()) {

                return $this->sendSuccessfullyResponse('success',trans('doctors.update'),201,$doctor);
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
        $doctor = $this->model::findOrFail($id);

        if ($doctor->status == $this->model::ACTIVE) {
            return $this->sendFailedResponse('success', trans('doctors.failed'), 403);
        }


        if ($doctor->delete()) {
            return $this->sendSuccessfullyResponse('success', trans('doctors.delete'), 200);
        }
        return $this->sendFailedResponse('success', trans('doctors.failed'), 500);
    }
}
