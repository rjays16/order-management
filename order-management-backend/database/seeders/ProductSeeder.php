<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop Stand',         'description' => 'Adjustable aluminum stand',  'price' => 1200, 'stock' => 5],
            ['name' => 'Mechanical Keyboard',  'description' => 'RGB backlit, tactile switches', 'price' => 3500, 'stock' => 23],
            ['name' => 'USB-C Hub',            'description' => '7-in-1 multiport adapter',     'price' => 1800, 'stock' => 8],
            ['name' => 'Webcam HD',            'description' => '1080p with built-in mic',      'price' => 2500, 'stock' => 35],
            ['name' => 'Mouse Pad XL',         'description' => 'Extra large desk mat',         'price' => 650,  'stock' => 42],
            ['name' => 'Monitor Light',        'description' => 'USB powered screen bar',       'price' => 1900, 'stock' => 0],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
