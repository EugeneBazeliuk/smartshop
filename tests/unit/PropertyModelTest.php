<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\Property;

/**
 * Class MetaModelTest
 */
class PropertyModelTest extends PluginTestCase
{
    public static $property = [
        // Base
        'name' => 'Test name',
        'code' => 'test-code',
        'description' => 'Test Description',
        // States
        'is_active' => true,
    ];

    public function test_create_product_property()
    {
        Property::truncate();

        // Create model
        $model = new Property;
        $model->fill(self::$property);

        // Save Model
        $model->save();

        // Create Related Categories Model
        $model->products()->create(ProductModelTest::$product);

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$property as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }

        // Assert Related ProductProperties Model
        $this->assertEquals(1, $model->products()->count());
    }
}