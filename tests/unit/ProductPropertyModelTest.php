<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\ProductProperty;

/**
 * Class MetaModelTest
 */
class ProductPropertyModelTest extends PluginTestCase
{
    public static $productProperty = [
        // Base
        'name' => 'Test name',
        'code' => 'test-code',
        'description' => 'Test Description',
        // States
        'is_active' => true,
    ];

    public function test_create_product_property()
    {
        ProductProperty::truncate();

        // Create model
        $model = new ProductProperty;
        $model->fill(self::$productProperty);

        // Save Model
        $model->save();

        // Create Related Categories Model
        $model->products()->create(ProductModelTest::$product);

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$productProperty as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }

        // Assert Related ProductProperties Model
        $this->assertEquals(1, $model->products()->count());
    }
}