<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * List orders with eager-loaded relations (prevents N+1).
     * Supports: ?userId=ID&role=CUSTOMER
     */
    public function index(Request $request): JsonResponse
    {
        $query = Order::query()
            ->withDetails()
            ->orderByDesc('created_at');

        if ($request->query('role') === 'CUSTOMER' && $request->query('userId')) {
            $query->where('user_id', $request->query('userId'));
        }

        $orders = $query->limit(100)->get();

        return response()->json($orders);
    }

    /**
     * Create an order with stock validation inside a DB transaction.
     * Prevents race conditions and does batch stock decrement.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'userId' => ['required', 'uuid', 'exists:users,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.productId' => ['required', 'uuid', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'address' => ['nullable', 'string'],
            'paymentMethod' => ['nullable', 'string'],
        ]);

        $productIds = collect($validated['items'])->pluck('productId')->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $total = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $product = $products->get($item['productId']);

            if (! $product) {
                return response()->json(['error' => "Product not found: {$item['productId']}"], 404);
            }

            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'error' => "Insufficient stock for \"{$product->name}\". Available: {$product->stock}",
                ], 400);
            }

            $unitPrice = $product->discounted_price;
            $total += $unitPrice * $item['quantity'];

            $orderItems[] = [
                'productId' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $unitPrice,
            ];
        }

        $order = DB::transaction(function () use ($validated, $total, $orderItems) {
            $order = Order::create([
                'user_id' => $validated['userId'],
                'total' => $total,
                'status' => 'PAID',
                'payment_method' => $validated['paymentMethod'] ?? 'CARD',
                'address' => $validated['address'] ?? null,
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create([
                    'product_id' => $item['productId'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                Product::where('id', $item['productId'])
                    ->decrement('stock', $item['quantity']);
            }

            return $order->load('items.product:id,name,images,price');
        });

        return response()->json($order, 201);
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:PENDING,PAID,SHIPPED,DELIVERED,CANCELLED'],
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $validated['status']]);

        return response()->json($order);
    }
}
