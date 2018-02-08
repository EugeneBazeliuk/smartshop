<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\Meta;
use Smartshop\Catalog\Models\Binding;
use Smartshop\Catalog\Models\BindingType;

/**
 * Class MetaModelTest
 */
class BindingModelTest extends PluginTestCase
{
    public static $binding = [
        // Base
        'name' => 'Test Name',
        'slug' => 'test-slug',
        'description' => '<b>Test Description</b>',
        // States
        'is_active' => true,
        'is_searchable' => true,
    ];

    public function test_create_category()
    {
        Binding::truncate();

        $model = new Binding();
        $model->fill(self::$binding);

        // Create Meta Relation
        $model->meta = new Meta();
        $model->meta->fill(MetaModelTest::$meta);

        // Create BindingType Relation
        $model->binding_type = BindingType::create(BindingTypeModelTest::$bindingType);

        // Save Model
        $model->save();

        // Create Related Categories Model
        $model->products()->create(ProductModelTest::$product);

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$binding as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }

        // Assert model meta attributes
        foreach (MetaModelTest::$meta as $key => $val) {
            $this->assertEquals($val, $model->meta->{$key});
        }

        // Assert Related Products Model
        $this->assertEquals(1, $model->products()->count());
    }
}