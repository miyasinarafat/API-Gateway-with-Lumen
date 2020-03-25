<?php

namespace App\Http\Controllers;

use App\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use ApiResponse;

    /**
     * list of users
     * @return JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return $this->validResponse($users, 'List of users');
    }

    /**
     *  create new user
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::create($request->all());
        return $this->validResponse($user, 'User created', 201);
    }

    /**
     *  show user profile
     * @param $user
     * @return JsonResponse
     */
    public function show($user)
    {
        $user = User::findOrFail($user);
        return $this->validResponse($user, 'Showing user profile');
    }

    /**
     * update user info
     * @param Request $request
     * @param $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'name' => 'max:255',
            'email' => 'email|unique:users,email,'.$user,
            'password' => 'min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($user);
        $user->fill($request->all());

        if ($user->isClean())
            return $this->errorResponse('At least one value must change', 422);

        $user->save();

        return $this->validResponse($user, 'Updated user profile');
    }

    /**
     * remove user
     * @param $user
     * @return JsonResponse
     */
    public function destroy($user)
    {
        $userProfile = User::findOrFail($user);
        $userProfile->delete();
        return $this->validResponse(['id' => $user], 'User deleted');
    }

    public function me(Request $request)
    {
        return $this->validResponse($request->user(), 'Authenticated user.');
    }
}
