<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use Smartshop\Catalog\Models\BindingType;

/**
 * Class MetaModelTest
 */
class BindingTypeModelTest extends PluginTestCase
{
    public static $bindingType = [
        // Base
        'name' => 'Test Name',
        'code' => 'test-code',
        'page' => 'test/test',
        'description' => '<b>Test Description</b>',
    ];

    public function test_create_category()
    {
        BindingType::truncate();

        $model = new BindingType();
        $model->fill(self::$bindingType);

        // Save Model
        $model->save();

        // Create Bindings Relation
        $model->bindings()->create(BindingModelTest::$binding);

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$bindingType as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }

        // Assert Bindings Relation Count
        $this->assertEquals(1, $model->bindings()->count());
    }
}