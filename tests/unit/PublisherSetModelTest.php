<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\Meta;
use Smartshop\Catalog\Models\Publisher;
use Smartshop\Catalog\Models\PublisherSet;

/**
 * Class MetaModelTest
 */
class PublisherSetModelTest extends PluginTestCase
{
    public static $publisherSet = [
        // Base
        'name' => 'Test Name',
        'slug' => 'test-slug',
        'description' => '<b>Test Description</b>',
        // States
        'is_active' => true,
        'is_searchable' => true,
    ];

    public function test_Create_publisher_set()
    {
        PublisherSet::truncate();

        // Create model
        $model = new PublisherSet;
        $model->fill(self::$publisherSet);

        // Create Meta Relation
        $model->meta = new Meta();
        $model->meta->fill(MetaModelTest::$meta);

        // Create Publisher Relation
        $model->publisher = Publisher::create(PublisherModelTest::$publisher);

        // Save Model
        $model->save();

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$publisherSet as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }

        // Assert model meta attributes
        foreach (MetaModelTest::$meta as $key => $val) {
            $this->assertEquals($val, $model->meta->{$key});
        }

        // Assert model publisher attributes
        foreach (PublisherModelTest::$publisher as $key => $val) {
            $this->assertEquals($val, $model->publisher->{$key});
        }
    }
}