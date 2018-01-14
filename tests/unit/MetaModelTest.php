<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\Meta;

/**
 * Class ProductsTest
 */
class MetaModelTest extends PluginTestCase {

    public static $meta = [
        'meta_title' => 'Test Meta Title',
        'meta_description' => 'Test Meta Description',
        'meta_keywords' => 'Test Meta Keywords',
        'canonical_url' => 'https://localhost',
        'redirect_url' => 'https://localhost',
        'robot_index' => 'index',
        'robot_follow' => 'follow'
    ];

    public function test_create_meta()
    {
        Meta::truncate();

        // Create Model
        $meta = new Meta();
        $meta->fill(self::$meta);
        $meta->save();

        // Assert Id
        $this->assertEquals(1, $meta->id);

        // Assert fields
        foreach (self::$meta as $key => $val) {
            $this->assertEquals($val, $meta->{$key});
        }
    }
}