<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Support\JsonResponseTrait;
use App\Http\Requests\Role\CreateRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Http\Repositories\RolesRepository;

class RolesController extends Controller
{
    use JsonResponseTrait;
    
    private $rolesRepository;

    public function __construct(RolesRepository $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->rolesRepository->all($request);
    }
    /** 
     * Store a newly created Role in storage
     * 
     * @param \App\Http\Request\Create
     */
    public function store(CreateRequest $request)
    {
        if (!Gate::allows('Create Role')) {
            return $this->sendFailedResponse('success', trans('roles.permission'),401);
        }
        return $this->rolesRepository->create($request->validated());
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->rolesRepository->update($request->validated(), $id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->rolesRepository->delete($id);
    }
}