<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request){
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return new UserResource($user);
    }

    public function login(LoginUserRequest $request){
        $credentials = $request->validated();
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'No user with these credentials'
            ],401);
        }

        $user = User::where('email',$credentials['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function show(User $user){
        return new UserResource($user);
    }

    public function index(){
        return UserResource::collection(User::paginate(10));
    }
}
