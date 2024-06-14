<?php

namespace App\Http\Controllers;

use App\Models\EventTicketCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request): JsonResponse
    {
        $rules = [
            'event_id' => 'required|exists:events,id',
            'items' => 'required|array',
            'items.*.event_ticket_category_id' => 'required|exists:event_ticket_categories,id',
            'items.*.quantity' => 'required|integer|min:1'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = $request->user();
        $event_id = $request->input('event_id');
        $items = $request->input('items');
        $total_amount = 0;

        foreach ($items as $item) {
            $category = EventTicketCategory::find($item['event_ticket_category_id']);
            $total_amount += $category->price * $item['quantity'];
        }

        DB::beginTransaction();

        try {
            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'event_id' => $event_id,
                'total_amount' => $total_amount,
                'order_status' => Order::STATUS_PENDING,
            ]);

            // Create order items and update ticket availability
            foreach ($items as $item) {
                $category = EventTicketCategory::find($item['event_ticket_category_id']);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'event_ticket_category_id' => $item['event_ticket_category_id'],
                    'quantity' => $item['quantity'],
                    'price' => $category->price,
                ]);

                $category->ticket_stock -= $item['quantity'];
                $category->save();
            }

            // Commit the transaction
            DB::commit();

            // Process payment (this is a placeholder, implement your payment logic)
            // If payment is successful:
            // $order->order_status = Order::STATUS_SUCCESS;
            // If payment fails:
            // $order->order_status = Order::STATUS_FAILED;
            $order->save();

            return response()->json(['status' => 'success', 'data' => $order], 201);

        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            return response()->json(['status' => 'error', 'message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function getAll(): JsonResponse
    {
        $perPage = 10;
        $orders = Order::with('order_details')
                        ->orderBy('id', 'asc')
                        ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'all orders',
            'data' => $orders,
        ], 200);
    }

    public function getUserOrders(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $perPage = 10;
            $orders = Order::with('order_details')
                            ->where('user_id', $user->id)
                            ->orderBy('id', 'asc')
                            ->paginate($perPage);
    
            return response()->json([
                'status' => 'success',
                'message' => 'all orders',
                'data' => $orders,
            ], 200);        
        } catch (\Exception $e) {
            Log::error('Error when fetching user orders: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'could not fetch orders',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
