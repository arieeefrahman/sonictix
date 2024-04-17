<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), Event::rules());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $event = Event::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'event created successfully',
            'data' => $event,
        ]);
    }
}
