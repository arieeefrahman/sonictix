<?php

namespace App\Http\Controllers;

use App\Models\Talent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TalentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), Talent::rules());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $talent = Talent::create($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'talent added successfully',
            'data' => $talent,
        ], 200);
    }

    public function getAll(): JsonResponse
    {
        $perPage = 10;
        $talents = Talent::paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'all talents',
            'data' => $talents,
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
            $talent = Talent::findOrFail($id);
            return response()->json([
                'status' => 'success',  
                'message' => 'talent with id = ' . $id,
                'data' => $talent,
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

        $validator = Validator::make($request->all(), Talent::rules('update'));
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $talent = Talent::findOrFail($id);
            $talent->update($request->all());
            return response()->json([
                'status' => 'success',  
                'message' => 'talent with id = ' . $id . ' updated successfully',
                'data' => $talent,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'talent not found',
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

        $validator = Validator::make($request->all(), Talent::rules($id));
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $talent = Talent::findOrFail($id);
            $talent->delete();
            return response()->json([
                'status' => 'success',  
                'message' => 'talent with id = ' . $id . ' deleted successfully',
                'data' => $talent,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'talent not found',
            ], 404);
        }
    }
}
