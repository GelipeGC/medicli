<?php

namespace App\Http\Controllers\Admin;

use App\Sortable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Http\Interfaces\UserInterface;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;

class UsersController extends Controller
{
    private $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->userRepository->all($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        return $this->userRepository->create($request->validated());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->userRepository->edit($id);
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
        return $this->userRepository->update($request->validated(), $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->userRepository->delete($id);
    }

    /**
     * Change the specified user status 
     */
    public function changeStatus(StatusRequest $request, $id)
    {
        return $this->userRepository->changeStatus($request->validated(), $id);
    }
}
