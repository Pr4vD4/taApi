<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'second_name' => 'required|max:255',
            'role' => 'between:0,3',
            'email' => 'required|email:rfc,dns|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($validator->validated());

        return response()->json([
            'message' => 'Success',
            'user' => new UserResource($user)
        ]);


    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_or_email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::query()->where('phone', $request->phone_or_email)->orWhere('email', $request->phone_or_email)->first();

        if ($user and Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $token = Auth::user()->createToken('login');
            return response()->json([
                'message' => 'Success',
                'token' => $token->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => 'Wrong username or password'
        ], 400);


    }
}
