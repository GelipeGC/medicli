<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Support\JsonResponseTrait;
use App\Http\Requests\Role\CreateRequest;
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
}
