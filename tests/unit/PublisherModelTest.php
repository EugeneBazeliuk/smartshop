<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\Meta;
use Smartshop\Catalog\Models\Publisher;

/**
 * Class MetaModelTest
 */
class PublisherModelTest extends PluginTestCase
{
    public static $publisher = [
        // Base
        'name' => 'Test Name',
        'slug' => 'test-slug',
        'description' => '<b>Test Description</b>',
        // States
        'is_active' => true,
        'is_searchable' => true,
    ];

    public function test_Create_publisher()
    {
        Publisher::truncate();

        // Create model
        $model = new Publisher();
        $model->fill(self::$publisher);

        // Create Meta Relation
        $model->meta = new Meta();
        $model->meta->fill(MetaModelTest::$meta);

        // Save Model
        $model->save();

        // Create Product Relation
        $model->products()->create(ProductModelTest::$product);

        // Create PublisherSet Relation
        $model->sets()->create(PublisherSetModelTest::$publisherSet);

        // Assert Id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$publisher as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }

        // Assert product meta fields
        foreach (MetaModelTest::$meta as $key => $val) {
            $this->assertEquals($val, $model->meta->{$key});
        }

        // Assert HasMany Sets
        $this->assertEquals(1, $model->sets()->count());

        // Assert HasMany Products
        $this->assertEquals(1, $model->products()->count());
    }
}