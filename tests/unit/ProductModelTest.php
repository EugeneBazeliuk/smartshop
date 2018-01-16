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

    public function test_create_product()
    {
        Product::truncate();

        // Create model
        $model =new Product;
        $model->fill(self::$product);

        // Create Meta Relation
        $model->meta = new Meta();
        $model->meta->fill(MetaModelTest::$meta);

        // Save Model
        $model->save();

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$product as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }

        // Assert model meta attributes
        foreach (MetaModelTest::$meta as $key => $val) {
            $this->assertEquals($val, $model->meta->{$key});
        }
    }
}