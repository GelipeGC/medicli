<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Support\JsonResponseTrait;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\RoleManagerResource;

class RoleManagerController extends Controller
{
    use JsonResponseTrait;
    const ITEM_PER_PAGE = 15;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|ResourceCollection
     */
    public function permissionsIndex()
    {
        return RoleManagerResource::collection(Permission::all()->paginate(static::ITEM_PER_PAGE));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|ResourceCollection
     */
    public function rolesIndex()
    {
        return Role::all()->paginate();
    }

    public function rolesAddUser(Request $request, Role $role, User $user)
    {
        $user->assignRole($role);

        return $this->sendSuccessfullyResponse('success', $role->name ." Role successfully assigned to user!", Response::HTTP_OK);
    }

    public function rolesRemoveUser(Request $request, Role $role, User $user)
    {
        $user->removeRole($role);
        return $this->sendSuccessfullyResponse('success', $role->name ." Role successfully remove from user!", Response::HTTP_OK);
    }
}
