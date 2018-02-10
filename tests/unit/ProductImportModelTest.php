<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use Smartshop\Catalog\Models\Product;
use Smartshop\Catalog\Models\ProductImport;

/**
 * Class MetaModelTest
 */
class ProductImportModelTest extends PluginTestCase
{
    public static $importData = [
        'title' => 'Product name',
        'sku' => '123456',
        'isbn' => '12345678',
        'price' => 100.00,
        'description' => '<b>Test Product Description</b>',
        // Sizes
        'width' => 10.11,
        'height' => 11.12,
        'depth' => 12.13,
        'weight' => 13.14,
        // Relations
        'bindings' => 'binding_type_1::binding_name_1',
        'categories' => 'category_1|category_2',
        'properties' => 'property::value',
        'publisher' => 'publisher_name',
        'publisher_set' => 'publisher_set_name',
        // States
        'is_active' => true,
        'is_searchable' => true,
        'is_unique_text' => true
    ];

    public function test_import_product()
    {
        Product::truncate();

        $importModel = new ProductImport;
        $importModel->importData([
            self::$importData
        ]);

        $results = $importModel->getResultStats();

        // Assert created count
        $this->assertEquals(1, $results->created);
        // Assert updated count
        $this->assertEquals(0, $results->updated);
        // Assert errors count
        $this->assertEquals(0, $results->errorCount);

        $model = Product::whereSku(self::$importData['sku'])->first();

        // Assert Product model fields
        $this->assertEquals(self::$importData['title'], $model->title);
        $this->assertEquals(self::$importData['sku'], $model->sku);
        $this->assertEquals(self::$importData['isbn'], $model->isbn);
        $this->assertEquals(self::$importData['price'], $model->price);
        $this->assertEquals(self::$importData['width'], $model->width);
        $this->assertEquals(self::$importData['height'], $model->height);
        $this->assertEquals(self::$importData['depth'], $model->depth);
        $this->assertEquals(self::$importData['weight'], $model->weight);
        $this->assertEquals(self::$importData['is_active'], $model->is_active);
        $this->assertEquals(self::$importData['is_searchable'], $model->is_searchable);
        $this->assertEquals(self::$importData['is_unique_text'], $model->is_unique_text);

        // Assert Binding
        $this->assertDatabaseHas('smartshop_bindings', ['name' => 'binding_name_1']);


//        // Assert Binding Relation
//        $this->assertEquals(1, $model->bindings()->count());
//
//        // Assert Categories Relation
//        $this->assertEquals(2, $model->categories()->count());
//
//        // Assert Publisher model
//        $this->assertEquals(self::$importData['publisher'], $model->publisher->name);
//
//        // Assert PublisherSet model
//        $this->assertEquals(self::$importData['publisher_set'], $model->publisher_set->name);
    }
}