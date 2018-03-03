<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\ImportTemplate;

/**
 * Class MetaModelTest
 */
class ImportTemplateModelTest extends PluginTestCase
{
    public static $importTemplate = [
        // Base
        'name' => 'Test Name',
        'description' => '<b>Test Description</b>',
        'mapping' => [],
    ];

    public function test_create_category()
    {
        ImportTemplate::truncate();

        $model = new ImportTemplate();
        $model->fill(self::$importTemplate);
        $model->save();

        // Assert model attributes
        foreach (self::$importTemplate as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }
    }
}