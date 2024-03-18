<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => ['required', 'string', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8'],
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        
        $user = UserModel::create([
            'username'  => $request['username'],
            'password'  => bcrypt($request['password']),
            'email'  => $request['email'],
            'full_name'  => $request['full_name'],
        ]);

        return response()->json([
            'message'=>'user created successfully',
            'user'=> $user,
        ], 201);
    }

    public function login()
    {

    }
}
