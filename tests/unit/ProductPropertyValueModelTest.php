<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\PropertyValue;

/**
 * Class MetaModelTest
 */
class ProductPropertyValueModelTest extends PluginTestCase
{
    public static $propertyValue = [
        // Base
        'value' => 'Test value',
    ];

    public function test_create_product_property_value()
    {
        PropertyValue::truncate();

        // Create model
        $model = new PropertyValue;
        $model->fill(self::$propertyValue);

        // Save Model
        $model->save();

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$propertyValue as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }
    }
}