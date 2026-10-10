<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard stats — all queries run independently, no N+1.
     * Uses aggregate functions and groupBy instead of loading full models.
     */
    public function stats(): JsonResponse
    {
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $categoryCount = Category::count();

        $totalRevenue = Order::sum('total');

        $categories = Category::withCount('products')
            ->select(['name', 'slug'])
            ->get()
            ->map(fn (Category $c) => [
                'name' => $c->name,
                'slug' => $c->slug,
                'productCount' => $c->products_count,
            ]);

        $usersByRole = User::query()
            ->select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');

        $lowStock = Product::lowStock()
            ->with(['category:id,name', 'supplier:id,name'])
            ->select(['id', 'name', 'stock', 'category_id', 'supplier_id'])
            ->orderBy('stock')
            ->limit(5)
            ->get()
            ->map(fn (Product $p) => [
                'id' => $p->id,
                'name' => $p->name,
                'stock' => $p->stock,
                'category' => $p->category->name,
                'supplier' => $p->supplier->name,
            ]);

        return response()->json([
            'totals' => [
                'users' => $userCount,
                'products' => $productCount,
                'orders' => $orderCount,
                'categories' => $categoryCount,
                'revenue' => (float) $totalRevenue,
            ],
            'categories' => $categories,
            'usersByRole' => $usersByRole,
            'lowStock' => $lowStock,
        ]);
    }

    /**
     * Sales chart data — optimized with DB aggregation instead of loading all records.
     * Uses groupBy queries instead of loading all products + orderItems (N+1 fix).
     */
    public function salesChart(): JsonResponse
    {
        $since = Carbon::now()->subDays(6)->startOfDay();

        $dailySales = Order::query()
            ->where('created_at', '>=', $since)
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as count'),
            ])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $since->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');
            $record = $dailySales->get($dateStr);

            $days[] = [
                'date' => $dateStr,
                'label' => $date->format('D'),
                'total' => $record ? (float) $record->total : 0,
                'count' => $record ? (int) $record->count : 0,
            ];
        }

        $byCategory = OrderItem::query()
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select([
                'categories.name',
                DB::raw('SUM(order_items.quantity) as value'),
            ])
            ->groupBy('categories.name')
            ->get();

        return response()->json([
            'days' => $days,
            'byCategory' => $byCategory,
        ]);
    }
}
