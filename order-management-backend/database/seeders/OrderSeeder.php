<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::pluck('name', 'id');

        $orders = [
            [
                'number' => 'ORD-001', 'status' => 'Confirmed', 'total' => 1200,
                'items' => [['product_id' => 1, 'name' => $products[1], 'qty' => 1, 'price' => 1200]],
            ],
            [
                'number' => 'ORD-002', 'status' => 'Pending', 'total' => 850,
                'items' => [
                    ['product_id' => 5, 'name' => $products[5], 'qty' => 1, 'price' => 650],
                    ['product_id' => 3, 'name' => $products[3], 'qty' => 1, 'price' => 200],
                ],
            ],
            [
                'number' => 'ORD-003', 'status' => 'Confirmed', 'total' => 3400,
                'items' => [['product_id' => 2, 'name' => $products[2], 'qty' => 1, 'price' => 3500]],
            ],
            [
                'number' => 'ORD-004', 'status' => 'Cancelled', 'total' => 620,
                'items' => [['product_id' => 5, 'name' => $products[5], 'qty' => 1, 'price' => 650]],
            ],
            [
                'number' => 'ORD-005', 'status' => 'Pending', 'total' => 2100,
                'items' => [['product_id' => 4, 'name' => $products[4], 'qty' => 1, 'price' => 2500]],
            ],
        ];

        foreach ($orders as $data) {
            $items = $data['items'];
            unset($data['items']);

            $order = Order::create($data);
            $order->items()->createMany($items);
        }
    }
}
