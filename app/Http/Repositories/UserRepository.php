<?php

namespace App\Http\Repositories;

use App\User;
use App\Sortable;
use App\Models\Area;
use App\Mail\WelcomeMail;
use Illuminate\Support\Str;
use App\Http\Support\GeneralTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Interfaces\UserInterface;
use App\Http\Support\JsonResponseTrait;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserRepository implements UserInterface
{
    use JsonResponseTrait, GeneralTrait;
    
    protected $model;

    /**
     * UserRepository constructor.
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
                            ->applyFilters()
                            ->orderByDesc('created_at')
                            ->paginate(10);
    }
    /**
     * Store a new created user in database.
     *
     * @param  array $data
     * @return array $json 
     */

    public function create(array $data)
    {
        try {
            $password = Str::random(8);

            $user = new $this->model();
            $user->name = $this->initCap($data['name']);
            $user->email = Str::lower($data['email']);
            $user->phone = $data['phone'];
            $user->address = $data['address'];
            $user->password = Hash::make($password);

            if ($user->save()) {

                $this->sendMailWelcome($user, $password);

                return $this->sendSuccessfullyResponse('success', trans('users.create'), 201, $user);
            }
            return $this->sendFailedResponse('success', trans('users.failed'), 500);

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
        return $this->model::select(['id','name','first_name','last_name','cellphone','email','profession_id','status','access_mobile','rol_id','parent_id','created_at'])
                ->with('role','areas','profession')
                ->findOrFail($id);
    }

    /**
     * Update the specified user in database.
     *
     * @param  array $data
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(array $data, $id)
    {
        try {
            $user = $this->model::findOrFail($id);
            $user->name = $this->initCap($data['name']);
            $user->email = Str::lower($data['email']);
            $user->phone = $data['phone'];
            $user->address = $data['address'];
            if ($user->update()) {

                return $this->sendSuccessfullyResponse('success',trans('users.update'),201,$user);
            }
            return $this->sendFailedResponse('success',trans('users.failed'), 500);
            
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
            return $this->sendFailedResponse('success', trans('users.failed'), 403);
        }
        

        if ($user->delete()) {
            return $this->sendSuccessfullyResponse('success', trans('users.delete'), 200);
        }
        return $this->sendFailedResponse('success', trans('users.failed'), 500);
    }
    /**
     * Send message a new user to welcome
     * 
     * @param object $user
     * @param string $password
     * 
     */
    protected function sendMailWelcome($user, $password)
    {
        Mail::to($user->email)->send(new WelcomeMail($user,$password));
    }
    /**
     * Change status of user in database
     * 
     * @param array $data
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(array $data, $id)
    {
        $user = $this->model::findOrFail($id);
        $user->status = $data['status'];

        if ($user->save()) {
            return $this->sendSuccessfullyResponse('success',trans('users.status'),201);
        }
        return $this->sendFailedResponse('success',trans('users.failed'), 500);

    }  

}
