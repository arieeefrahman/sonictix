<?php

namespace App\Http\Controllers;

use App\Models\EventTicketCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventTicketCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request): JsonResponse
    {
        $requestData = $request->all();
        if (!is_array($requestData)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'request must be in array',
            ], 400);
        }

        $validationErrors = [];
        foreach ($requestData as $data) {
            $validator = Validator::make($data, EventTicketCategory::rules());
            if ($validator->fails()) {
                $validationErrors[] = $validator->errors();
            }
        }

        if (!empty($validationErrors)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed for some records',
                'errors' => $validationErrors
            ], 400);
        }

        $createdRecords = [];
        foreach ($requestData as $data) {
            $createdRecords[] = EventTicketCategory::create($data);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'ticket categories created successfully',
            'data'      => $createdRecords,
        ]);
    }

    public function getByEventId(Request $request): JsonResponse
    {
        $event_id = $request->event_id;
        if (!is_numeric($event_id)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'event_id must be numeric only',
            ], 400);
        }

        $eventTicketCategories = EventTicketCategory::where('event_id', 'like', '%' . $event_id . '%')->get();
        if ($eventTicketCategories->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'ticket categories not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',  
            'message' => 'event ticket categories with event id = ' . $event_id,
            'data' => $eventTicketCategories,
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
            $eventTicketCategories = EventTicketCategory::findOrFail($id);
            return response()->json([
                'status' => 'success',  
                'message' => 'ticket categories with event id = ' . $id,
                'data' => $eventTicketCategories,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'ticket categories not found',
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

        $validator = Validator::make($request->all(), EventTicketCategory::rules());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $eventTicketCategories = EventTicketCategory::findOrFail($id);
            $eventTicketCategories->update($request->all());
            return response()->json([
                'status' => 'success',  
                'message' => 'ticket categories with id = ' . $id . ' updated successfully',
                'data' => $eventTicketCategories,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'ticket category not found',
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

        $validator = Validator::make($request->all(), EventTicketCategory::rules());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $eventTicketCategories = EventTicketCategory::findOrFail($id);
            $eventTicketCategories->delete();
            return response()->json([
                'status' => 'success',  
                'message' => 'ticket categories with id = ' . $id . ' updated successfully',
                'data' => $eventTicketCategories,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'ticket category not found',
            ], 404);
        }
    }
}