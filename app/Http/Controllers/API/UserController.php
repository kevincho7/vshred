<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\User as UserResource;
use Validator;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends BaseController
{
    private $userRepository;

    private function validate_data($input)
    {
        return Validator::make($input, [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
    }

    public function __construct(UserRepositoryInterface $userRepository)
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
        if ($request->user()->hasRole('Admin'))
        {
            $users = $this->userRepository->all();

            return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
        }

        return response()->json(['error' => 'Unauthorized.'], 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->hasRole('Admin'))
        {
            $input = $request->all();
            $validator = $this->validate_data($input);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = $this->userRepository->store($input);

            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User created successfully.');
        }

        return response()->json(['error' => 'Unauthorized.'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->user()->hasRole('Admin') || $request->user()->id == $id)
        {
            $user = $this->userRepository->show($id);

            if (is_null($user)) {
                return $this->sendError('User not found.');
            }

            return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
        }

        return response()->json(['error' => 'Unauthorized.'], 403);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->user()->hasRole('Admin') || $request->user()->id == $id)
        {
            $input = $request->all();

            $validator = $this->validate_data($input);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $user = $this->userRepository->update($input, $id);

            return $this->sendResponse(new UserResource($user), 'User updated successfully.');
        }

        return response()->json(['error' => 'Unauthorized.'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if ($request->user()->hasRole('Admin'))
        {
            $this->userRepository->delete($id);

            return $this->sendResponse([], 'User deleted successfully.');
        }

        return response()->json(['error' => 'Unauthorized.'], 403);

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
