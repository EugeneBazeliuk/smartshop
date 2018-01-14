<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\Meta;
use Smartshop\Catalog\Models\Product;

/**
 * Class MetaModelTest
 */
class ProductModelTest extends PluginTestCase
{
    public static $product = [
        // Base
        'title' => 'Test Product',
        'slug' => 'test-product-slug',
        'sku' => '123456',
        'isbn' => '12345678',
        'price' => 100.00,
        'description' => '<b>Test Product Description</b>',
        // Sizes
        'width' => 10.11,
        'height' => 11.12,
        'depth' => 12.13,
        'weight' => 13.14,
        // States
        'is_active' => true,
        'is_searchable' => true,
        'is_unique_text' => true
    ];

    public function testCreateProduct()
    {
        Product::truncate();

        // Create product
        $product = new Product;
        $product->fill(self::$product);
        $product->save();

        // Create product meta
        $product->meta = new Meta();
        $product->meta->fill(MetaModelTest::$meta);
        $product->meta->save();

        // Assert Id
        $this->assertEquals(1, $product->id);

        // Assert product fields
        foreach (self::$product as $key => $val) {
            $this->assertEquals($val, $product->{$key});
        }

        // Assert product meta fields
        foreach (MetaModelTest::$meta as $key => $val) {
            $this->assertEquals($val, $product->meta->{$key});
        }
    }
}