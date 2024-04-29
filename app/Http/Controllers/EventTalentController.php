<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTalent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventTalentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request): JsonResponse
    {
        $rules = [
            'talent_ids' => 'required|array',
            'talent_ids.*' => 'required|numeric|exists:talents,id',
        ];
    
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        // Check if the event exists
        $event = Event::find($request->event_id);
        if (!$event) {
            return response()->json([
                'status' => 'failed',
                'message' => 'event id not exist'
            ], 404);
        }

        $eventTalents = [];

        $talentIds = $request->input('talent_ids');

        foreach ($talentIds as $talentId) {
            $eventTalent = EventTalent::create([
                'event_id' => $request->event_id,
                'talent_id' => $talentId,
            ]);
            $eventTalents[] = $eventTalent;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'event talent added successfully',
            'data' => $eventTalents,
        ], 200);
    }

    public function getAll(): JsonResponse
    {
        $perPage = 10;
        $eventTalents = EventTalent::paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'all event talents',
            'data' => $eventTalents,
        ], 200);
    }

    public function getById(Request $request): JsonResponse
    {
        $id = $request->id;
        if (!is_numeric($id)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'id must be numeric only',
            ], 400);
        }
        
        try {
            $eventTalent = EventTalent::findOrFail($id);
            return response()->json([
                'status' => 'success',  
                'message' => 'event talent with id = ' . $id,
                'data' => $eventTalent,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'event talent not found',
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

        $validator = Validator::make($request->all(), EventTalent::rules());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $eventTalent = EventTalent::findOrFail($id);
            $eventTalent->update($request->all());
            return response()->json([
                'status' => 'success',  
                'message' => 'event talent with id = ' . $id . ' updated successfully',
                'data' => $eventTalent,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'event talent not found',
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

        $validator = Validator::make($request->all(), EventTalent::rules($id));
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $eventTalent = EventTalent::findOrFail($id);
            $eventTalent->delete();
            return response()->json([
                'status' => 'success',  
                'message' => 'event talent with id = ' . $id . ' deleted successfully',
                'data' => $eventTalent,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'event talent not found',
            ], 404);
        }
    }
}
