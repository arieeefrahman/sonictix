<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => ['required', 'string', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8'],
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        
        $user = User::create([
            'full_name'  => $request['full_name'],
            'username'  => $request['username'],
            'password'  => bcrypt($request['password']),
            'email'  => $request['email'],
        ]);

        // Exclude password from the response
        $user = $user->toArray();
        unset($user['password']);

        return response()->json([
            "status" => 'success',
            'message'=>'user created successfully',
            'data'=> $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => ['required_without:email', 'nullable', 'string', 'max:255'],
            'password'  => ['required', 'string', 'max:100'],
            'email'     => ['required_without:username', 'nullable', 'string', 'email', 'max:255']
        ]);

        if ($request->has('username') && $request->has('email')) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Please provide either username or email, not both.'
            ], 400);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->has('username')) {
            $user = User::where('username', $request->username)->first();
        } else {
            $user = User::where('email', $request->email)->first();
        }

        // Check if the user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Username, email, or password is wrong'
            ], 401);
        }

        $credentials = $request->only('username', 'email', 'password');
        $token = auth('api')->setTTL(60)->attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate token',
            ], 500);
        }
        
        return response()->json([
                'status' => 'success',
                'data' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60,
                ]
            ]
        );
    }

    public function logout()
    {
        auth('api')->logout();
        
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $newToken = auth('api')->refresh();

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $newToken,
                'type' => 'bearer',
                ]
            ]
        );
    }

    public function me()
    {
        $user = auth('api')->user()->toArray();
        unset($user['password']);

        return response()->json([
            'status' => 'success',
            'message' => 'user information',
            'data' => $user,
        ], 200);
    }
    
}
