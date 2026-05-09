<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityLogResource;
use App\Http\Resources\OrderResource;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'Pending')->count();
        $totalRevenue = Order::where('status', 'Confirmed')->sum('total');

        $stats = [
            ['icon' => 'package', 'bg' => 'bg-blue-100', 'label' => 'Total Products', 'value' => (string) $totalProducts, 'trend' => '', 'trendColor' => ''],
            ['icon' => 'shopping-cart', 'bg' => 'bg-green-100', 'label' => 'Total Orders', 'value' => (string) $totalOrders, 'trend' => '', 'trendColor' => ''],
            ['icon' => 'dollar-sign', 'bg' => 'bg-green-100', 'label' => 'Total Revenue', 'value' => '₱' . number_format($totalRevenue), 'trend' => '', 'trendColor' => ''],
            ['icon' => 'clock', 'bg' => 'bg-yellow-100', 'label' => 'Pending Orders', 'value' => (string) $pendingOrders, 'trend' => '', 'trendColor' => ''],
        ];

        $recentOrders = OrderResource::collection(
            Order::with('items')->orderBy('id', 'desc')->limit(5)->get()
        );

        $inventory = Product::where('stock', '<=', 10)
            ->orderBy('stock')
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'stock' => $p->stock,
                'status' => $p->stock === 0 ? 'Out of Stock' : ($p->stock <= 10 ? 'Low Stock' : 'In Stock'),
            ]);

        $recentActivity = ActivityLogResource::collection(
            ActivityLog::orderBy('id', 'desc')->limit(5)->get()
        );

        return response()->json([
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'inventory' => $inventory,
            'recentActivity' => $recentActivity,
        ]);
    }
}
