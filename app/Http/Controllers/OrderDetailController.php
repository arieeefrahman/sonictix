<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getOrderDetail(Request $request): JsonResponse
    {
        $order_detail_id = $request->id;

        if (!is_numeric($order_detail_id)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'id must be numeric only',
            ], 400);
        }


        try {
            $order_detail = OrderDetail::with('order')->findOrFail($order_detail_id);

            $user = $request->user();
            if ($order_detail->order->user_id !== $user->id) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'you do not have permission to access this data',
                ], 403);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'order with id = ' . $order_detail_id,
                'data' => $order_detail,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'record not found',
                'data' => $e->getMessage(),
            ], 404);            
        }
    }
}
