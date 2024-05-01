<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), Category::rules());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $category = Category::create($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'category added successfully',
            'data' => $category,
        ], 200);
    }

    public function getAll(): JsonResponse
    {
        $perPage = 10;
        $categories = Category::paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'all categories',
            'data' => $categories,
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
            $category = Category::findOrFail($id);
            return response()->json([
                'status' => 'success',  
                'message' => 'talent with id = ' . $id,
                'data' => $category,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'category not found',
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

        $validator = Validator::make($request->all(), Category::rules('update'));
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $category = Category::findOrFail($id);
            $category->update($request->all());
            return response()->json([
                'status' => 'success',  
                'message' => 'category with id = ' . $id . ' updated successfully',
                'data' => $category,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'category not found',
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

        $validator = Validator::make($request->all(), Category::rules($id));
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'status' => 'success',  
                'message' => 'category with id = ' . $id . ' deleted successfully',
                'data' => $category,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'category not found',
            ], 404);
        }
    }
}
