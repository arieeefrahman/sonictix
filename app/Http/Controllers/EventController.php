<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request): JsonResponse
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
        ], 200);
    }

    public function getAll(): JsonResponse
    {
        $perPage = 10;
        $events = Event::paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'all events',
            'data' => $events,
        ], 200);
    }

    public function getByID(Request $request): JsonResponse
    {
        $id = $request->id;

        if (!is_numeric($id)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'id must be numeric only',
            ], 400);
        }
        
        try {
            $event = Event::findOrFail($id);
            return response()->json([
                'status' => 'success',  
                'message' => 'event with id = ' . $id,
                'data' => $event,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'event not found',
            ], 404);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request->id;
        if (!is_numeric($id)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'id must be numeric only',
            ], 400);
        }

        $validator = Validator::make($request->all(), Event::rules($id));
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        
        try {
            $event = Event::findOrFail($id);
            $event->update($request->all());
            return response()->json([
                'status' => 'success',  
                'message' => 'event with id = ' . $id . ' updated successfully',
                'data' => $event,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'event not found',
            ], 404);
        }
    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->id;

        if (!is_numeric($id)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'id must be numeric only',
            ], 400);
        }
        
        try {
            $event = Event::findOrFail($id);
            $event->delete();
            return response()->json([
                'status' => 'success',  
                'message' => 'event with id = ' . $id . ' deleted successfully',
                'data' => $event,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'event not found',
            ], 404);
        }
    }
}
