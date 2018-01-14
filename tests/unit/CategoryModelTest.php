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

    public function testCreateProduct()
    {
        Category::truncate();

        // Create product
        $category = new Category();
        $category->fill(self::$category);
        $category->save();

        // Create product meta
        $category->meta = new Meta();
        $category->meta->fill(MetaModelTest::$meta);
        $category->meta->save();

        // Assert Id
        $this->assertEquals(1, $category->id);

        // Assert product fields
        foreach (self::$category as $key => $val) {
            $this->assertEquals($val, $category->{$key});
        }

        // Assert product meta fields
        foreach (MetaModelTest::$meta as $key => $val) {
            $this->assertEquals($val, $category->meta->{$key});
        }
    }
}