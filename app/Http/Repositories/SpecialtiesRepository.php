<?php

namespace App\Http\Repositories;

use App\Models\Specialty;
use App\Http\Support\JsonResponseTrait;
use Illuminate\Database\QueryException;
use App\Http\Resources\SpecialtyResource;

class SpecialtiesRepository
{
    use JsonResponseTrait;
    const ITEM_PER_PAGE = 10;
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param Specialty $specialty
     */
    public function __construct(Specialty $specialty)
    {
        $this->model = $specialty;
    }

    /**
     * Display a listing of the resource and apply filters by specialties
     * @return \Illuminate\Http\Response
     */
    public function all($request)
    {
        return $specialty = $this->model::query()
                        ->orderByDesc('created_at')
                        ->paginate(static::ITEM_PER_PAGE);
    }

    public function create(array $data)
    {
        try {
            $specialty = new $this->model();
            $specialty->name = $data['name'];
            $specialty->description = $data['description'];

            if ($specialty->save()) {
                return $this->sendSuccessfullyResponse('success', trans('specialties.create'), 201, new SpecialtyResource($specialty));
            }
            return $this->sendFailedResponse('success', trans('specialties.failed'), 500);

        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), 500);
        }

    }
    /**
     * Show the resource api for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $specialty = $this->model::findOrFail($id);
        return new SpecialtyResource($specialty);
    }
    public function update($data, $id)
    {
        try {
            $specialty = $this->model::findOrFail($id);
            $specialty->name = $data['name'];
            $specialty->description = $data['description'];
    
            if ($specialty->update()) {
                return $this->sendSuccessfullyResponse('success', trans('specialties.update'), 201, new SpecialtyResource($specialty));
            }
            return $this->sendFailedResponse('success', trans('specialties.failed'), 500);
        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), 500);
        }

    }
    public function delete($id)
    {
        try {
            $specialty = $this->model::findOrFail($id);

            if ($specialty->delete()) {
                return $this->sendSuccessfullyResponse('success', trans('specialties.delete'), 201);
            }
            return $this->sendFailedResponse('success', trans('specialties.failed'), 500);

        } catch (QueryException $e) {
            return $this->sendFailedResponse('success', $e->getMessage(), 500);
        }
    }
}