<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\ProductPropertyValue;

/**
 * Class MetaModelTest
 */
class ProductPropertyValueModelTest extends PluginTestCase
{
    public static $productPropertyValue = [
        // Base
        'value' => 'Test value',
    ];

    public function test_create_product_property_value()
    {
        ProductPropertyValue::truncate();

        // Create model
        $model = new ProductPropertyValue;
        $model->fill(self::$productPropertyValue);

        // Save Model
        $model->save();

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$productPropertyValue as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }
    }
}