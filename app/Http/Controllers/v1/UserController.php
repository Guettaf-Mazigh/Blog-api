<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ]);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $currentToken = $user?->currentAccessToken();

        if ($currentToken) {
            $currentToken->delete();
        } else {
            $user?->tokens()->delete();
        }

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function destroy(User $user){
        $user->tokens()->delete();
        $user->delete();
        return response()->noContent();
    }

    public function update(UpdateUserRequest $request, User $user){
        $data = $request->validated();
        if(array_key_exists('name',$data)){
            $updates['name'] = $data['name'];
        }
        if(array_key_exists('email',$data)){
            $updates['email'] = $data['email'];
        }
        if(array_key_exists('password',$data)){
            $updates['password'] = Hash::make($data['password']);
        }
        if(!empty($updates)){
            $user->update($updates);
        }
        return new UserResource($user->refresh());
    }
}
