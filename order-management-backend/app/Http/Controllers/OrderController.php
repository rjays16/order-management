<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        return OrderResource::collection($query->orderBy('id', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $orderNumber = 'ORD-' . str_pad(Order::max('id') + 1, 3, '0', STR_PAD_LEFT);

            $orderItems = [];
            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['qty']) {
                    abort(400, "Insufficient stock for {$product->name}");
                }

                $lineTotal = $product->price * $item['qty'];
                $total += $lineTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'qty' => $item['qty'],
                    'price' => $product->price,
                ];
            }

            $order = Order::create([
                'number' => $orderNumber,
                'status' => 'Pending',
                'total' => $total,
            ]);

            $order->items()->createMany($orderItems);

            $names = collect($orderItems)->pluck('name')->join(', ');
            ActivityLog::create([
                'type' => 'order',
                'message' => "Order {$orderNumber} created",
                'detail' => "Order Pending for {$names}",
            ]);

            return new OrderResource($order->load('items'));
        });
    }

    public function confirm(Order $order)
    {
        if ($order->status !== 'Pending') {
            return response()->json(['message' => 'Only pending orders can be confirmed'], 400);
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->cancelled) continue;

                $product = Product::findOrFail($item->product_id);

                if ($product->stock < $item->qty) {
                    abort(400, "Insufficient stock for {$item->name}");
                }

                $product->decrement('stock', $item->qty);

                ActivityLog::create([
                    'type' => 'deduct',
                    'message' => "Stock deducted for {$item->name}",
                    'detail' => "{$item->qty} unit(s) deducted (Order {$order->number} confirmed)",
                ]);
            }

            $order->update(['status' => 'Confirmed']);

            ActivityLog::create([
                'type' => 'order',
                'message' => "Order {$order->number} confirmed",
                'detail' => "Order status changed to Confirmed",
            ]);
        });

        return new OrderResource($order->load('items'));
    }

    public function cancel(Order $order)
    {
        if ($order->status === 'Cancelled') {
            return response()->json(['message' => 'Order is already cancelled'], 400);
        }

        DB::transaction(function () use ($order) {
            $previousStatus = $order->status;
            $order->update(['status' => 'Cancelled']);

            foreach ($order->items as $item) {
                if ($item->cancelled) continue;

                Product::where('id', $item->product_id)->increment('stock', $item->qty);

                ActivityLog::create([
                    'type' => 'restore',
                    'message' => "Stock restored for {$item->name}",
                    'detail' => "{$item->qty} unit(s) restored (Order {$order->number} cancelled)",
                ]);
            }

            ActivityLog::create([
                'type' => 'order',
                'message' => "Order {$order->number} cancelled",
                'detail' => "Order cancelled (was {$previousStatus})",
            ]);
        });

        return new OrderResource($order->load('items'));
    }

    public function cancelItem(Request $request, Order $order)
    {
        if ($order->status === 'Cancelled') {
            return response()->json(['message' => 'Cannot cancel items on a fully cancelled order'], 400);
        }

        $validated = $request->validate([
            'item_id' => 'required|exists:order_items,id',
        ]);

        DB::transaction(function () use ($order, $validated) {
            $item = $order->items()->where('id', $validated['item_id'])->firstOrFail();

            if ($item->cancelled) {
                abort(400, 'Item is already cancelled');
            }

            $item->update(['cancelled' => true]);

            Product::where('id', $item->product_id)->increment('stock', $item->qty);

            $subtotal = $item->qty * $item->price;
            $order->decrement('total', $subtotal);

            ActivityLog::create([
                'type' => 'restore',
                'message' => "Stock restored for {$item->name}",
                'detail' => "{$item->qty} unit(s) restored (Order {$order->number} item cancelled)",
            ]);

            ActivityLog::create([
                'type' => 'order',
                'message' => "Item {$item->name} cancelled in Order {$order->number}",
                'detail' => "Item was cancelled from order, subtotal removed: ₱{$subtotal}",
            ]);
        });

        return new OrderResource($order->load('items'));
    }
}
