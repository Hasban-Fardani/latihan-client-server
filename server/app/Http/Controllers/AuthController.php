<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message' => 'invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user)
        {
            return response()->json([
                'message' => 'User not found'
            ], 422);
        }

        if (!auth()->attempt($data))
        {
            return response()->json([
                'message' => 'Invalid password'
            ], 400);
        }

        $user->accessToken = $user->createToken('accessToken', [$user->role])->plainTextToken;
        return response()->json([
            'message' => 'Login success',
            'user' => $user
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create($validator->validated());

        return response()->json([
            'message' => 'Register Success',
            'user' => $user
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout success'
        ], 200);
    }

    public function me(Request $request){
        return $request->user();
    }
}
