<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Support\GeneralTrait;
use App\Http\Resources\PatientResource;
use App\Http\Support\JsonResponseTrait;

class PatientsRepository
{
    use JsonResponseTrait, GeneralTrait;
    const ITEM_PER_PAGE = 10;
    protected $model;
    /**
     * PatientsRepository constructor
     *
     * @param User $patient
     */
    public function __construct(User $patient)
    {
        $this->model = $patient;
    }
    public function all($request)
    {
        return $this->model::query()
                        ->select(['id','name','phone','email','created_at'])
                        ->onlyPatients()
                        ->applyFilters()
                        ->orderByDesc('created_at')
                        ->paginate(static::ITEM_PER_PAGE);
    }
    public function create(array $data)
    {
        try {
            $patient = new $this->model();
            $patient->name = $this->initCap($data['name']);
            $patient->email = Str::lower($data['email']);
            $patient->address = $data['address'];
            $patient->phone = $data['phone'];

            if ($patient->save()) {
                $patient->assignRole($data['role_id']);
                return $this->sendSuccessfullyResponse('success', trans('patients.create'), 201, new PatientResource($patient));
            }
            return $this->sendFailedResponse('success', trans('patients.failed'), 500);

        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), 500);
        }
    }
    public function update(array $data, int $id)
    {
        try {
            $patient = $this->model::findOrFail($id);
            $patient->name = $this->initCap($data['name']);
            $patient->email = Str::lower($data['email']);
            $patient->phone = $data['phone'];
            $patient->address = $data['address'];
            if ($patient->update()) {

                return $this->sendSuccessfullyResponse('success',trans('patients.update'),201,$patient);
            }
            return $this->sendFailedResponse('success',trans('patients.failed'), 500);

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
        $patient = $this->model::findOrFail($id);

        if ($patient->status == $this->model::ACTIVE) {
            return $this->sendFailedResponse('success', trans('patients.failed'), 403);
        }

        if ($patient->delete()) {
            return $this->sendSuccessfullyResponse('success', trans('patients.delete'), 200);
        }
        return $this->sendFailedResponse('success', trans('patients.failed'), 500);
    }

}
