<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Classes\FiltersUserPermission;
use App\Classes\FiltersUserRole;
use App\Traits\ApiResponseFormatTrait;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\QueryException;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Transformers\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    use ApiResponseFormatTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(['name', 'email','username', 'phone', AllowedFilter::custom('role', new FiltersUserRole), AllowedFilter::custom('permission', new FiltersUserPermission)])
            ->get();
        return (UserResource::collection($users))->additional($this->preparedResponse('index'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request->validated();

        if(Auth::user()->is_super_admin) {
           
            $userCount  = User::count();
            if($userCount == 1) {
                // create admin user
                $user = User::create($request->all());
                $user->assignRole('admin');
            }
            else{
                return $this->unauthorizedResponse('You are not allowed to create users');
            }
        }

        // If the user is not a super admin, check if they have permission to create users
        // This assumes you have a permission named 'manage users'
        elseif(Auth::user()->can('manage users')) {
            $user = User::create($request->all());

            // assign roles if set
            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }
        } 
        // If the user does not have permission, return an unauthorized response
        else {
            return $this->unauthorizedResponse('You are not allowed to create users');
        }

        // Log the activity of user creation
        activity('user created')->causedBy(Auth::user())->log('User ' . Auth::user()->username . ' created a new user: ' . $user->username);

        return (new UserResource($user))->additional($this->preparedResponse('store'));
    
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
      
       try {
            $user = User::findOrFail($id);
            return (UserResource::make($user))->additional($this->preparedResponse('show'));
        } catch (ModelNotFoundException $modelException) {
            return $this->recordNotFoundResponse($modelException);
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        }
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $request->validated();

        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            // assign or update roles if set
            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            activity('user updated')->causedBy(Auth::user())->log('User ' . Auth::user()->username . ' updated user: ' . $user->username);

            return (new UserResource($user))->additional($this->preparedResponse('update'));
        } catch (ModelNotFoundException $modelException) {
            return $this->recordNotFoundResponse($modelException);
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        }

         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            activity('user deleted')->causedBy(Auth::user())->log('User ' . Auth::user()->username . ' deleted user: ' . $user->username);

            return (new UserResource($user))->additional($this->preparedResponse('destroy'));

        } catch (ModelNotFoundException $modelException) {
            return $this->recordNotFoundResponse($modelException);
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        }
    }
}
