<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\Meta;
use Smartshop\Catalog\Models\Category;

/**
 * Class MetaModelTest
 */
class CategoryModelTest extends PluginTestCase
{
    public static $category = [
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
        Category::truncate();

        $model = new Category();
        $model->fill(self::$category);

        // Create Meta Relation
        $model->meta = new Meta();
        $model->meta->fill(MetaModelTest::$meta);

        // Save Model
        $model->save();

        // Create Related Categories Model
        $model->products()->create(ProductModelTest::$product);

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$category as $key => $val) {
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