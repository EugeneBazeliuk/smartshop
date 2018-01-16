<?php namespace SmartShop\Catalog\Seeders;

use Smartshop\Catalog\Models\Product;

class ProductSeeder extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        $product = Product::create([
            // Base
            'title' => 'First Product',
            'slug' => 'first-product-slug',
            'sku' => '123456',
            'isbn' => '1234567890',
            'price' => 100.00,
            'description' => '<b>Test Description</b>',
            // Sizes
            'width' => 10.00,
            'height' => 11.00,
            'depth' => 12.00,
            'weight' => 13.00,
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);
    }
}