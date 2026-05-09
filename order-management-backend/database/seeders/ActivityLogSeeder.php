<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $logs = [
            ['type' => 'order',   'message' => 'Order ORD-001 created',          'detail' => 'Order Confirmed for Laptop Stand'],
            ['type' => 'order',   'message' => 'Order ORD-002 created',          'detail' => 'Order Pending for Mouse Pad XL, USB-C Hub'],
            ['type' => 'order',   'message' => 'Order ORD-003 created',          'detail' => 'Order Confirmed for Mechanical Keyboard'],
            ['type' => 'order',   'message' => 'Order ORD-004 created',          'detail' => 'Order Cancelled for Mouse Pad XL'],
            ['type' => 'order',   'message' => 'Order ORD-005 created',          'detail' => 'Order Pending for Webcam HD'],
            ['type' => 'deduct',  'message' => 'Stock deducted for Laptop Stand', 'detail' => '1 unit deducted (Order ORD-001)'],
            ['type' => 'deduct',  'message' => 'Stock deducted for Mouse Pad XL', 'detail' => '1 unit deducted (Order ORD-002)'],
            ['type' => 'deduct',  'message' => 'Stock deducted for USB-C Hub',    'detail' => '1 unit deducted (Order ORD-002)'],
            ['type' => 'restore', 'message' => 'Stock restored for Mouse Pad XL', 'detail' => '1 unit restored (Order ORD-004 cancelled)'],
            ['type' => 'add',     'message' => 'Product Monitor Light added',     'detail' => 'New product added to inventory'],
        ];

        foreach ($logs as $log) {
            ActivityLog::create($log);
        }
    }
}
