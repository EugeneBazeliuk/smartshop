<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use Smartshop\Catalog\Models\Product;
use Smartshop\Catalog\Models\Binding;
use Smartshop\Catalog\Models\ProductImport;
use Smartshop\Catalog\Models\BindingType;
use Smartshop\Catalog\Models\Property;

/**
 * Class MetaModelTest
 */
class ProductImportModelTest extends PluginTestCase
{
    public static $data = [
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
        // States
        'is_active' => true,
        'is_searchable' => true,
        'is_unique_text' => true
    ];

    public function test_import_product()
    {
        // Run Import
        $results = $this->runImport(self::$data);

        // Check ProductImport results
        $this->checkResults($results, 1, 0, 0);

        // Get imported model
        $model = Product::where('sku', self::$data['sku'])->first();

        // Check model attributes
        foreach (self::$data as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }
    }

    public function test_import_product_publisher()
    {
        // Prepare Import data
        $data = array_merge(self::$data, [
            'publisher' => 'Test Publisher Name',
        ]);

        // Run Import
        $results = $this->runImport($data);

        // Check ProductImport results
        $this->checkResults($results, 1, 0, 0);

        // Find Model
        $model = Product::where('sku', $data['sku'])->first();

        // Check Publisher
        $this->assertNotNull($model->publisher, 'Publisher does not created');
        $this->assertEquals($data['publisher'], $model->publisher->name);
    }

    /**
     *
     */
    public function test_import_product_publisher_set()
    {
        // Prepare Import data
        $data = array_merge(self::$data, [
            'publisher' => 'Test Publisher Name',
            'publisher_set' => 'Test Publisher Set name',
        ]);

        // Run Import
        $results = $this->runImport($data);

        // Check ProductImport results
        $this->checkResults($results, 1, 0, 0);

        // Find Product
        $model = Product::where('sku', $data['sku'])->first();

        // Assert Publisher
        $this->assertNotNull($model->publisher_set, 'PublisherSet does not created');
        $this->assertEquals($data['publisher_set'], $model->publisher_set->name);
    }

    /**
     *
     */
    public function test_import_product_bindings()
    {
        // Prepare Import data
        $data = array_merge(self::$data, [
            'bindings' => 'test_code::Test Binding 1|test_code::Test Binding 2',
        ]);

        // Prepare BindingType
        BindingType::create([
            'name' => 'Test Name',
            'code' => 'test_code',
        ]);

        // Run Import
        $results = $this->runImport($data);

        // Check ProductImport results
        $this->checkResults($results, 1, 0, 0);

        // Find Models
        $model = Product::where('sku', $data['sku'])->first();
        $binding_1 = Binding::whereName('Test Binding 1')->first();
        $binding_2 = Binding::whereName('Test Binding 2')->first();

        // Assert Bindings
        $this->assertNotNull($binding_1, 'Binding 1 does not created');
        $this->assertEquals('test_code', $binding_1->binding_type->code);
        $this->assertNotNull($binding_2, 'Binding 2 does not created');
        $this->assertEquals('test_code', $binding_2->binding_type->code);
        $this->assertEquals(2, $model->bindings()->count(), 'Product Bindings does not created');
    }

    /**
     *
     */
    public function test_import_product_categories()
    {
        // Prepare Import data
        $data = array_merge(self::$data, [
            'categories' => 'Test category 1|Test category 2',
        ]);

        // Run Import
        $results = $this->runImport($data);

        // Check ProductImport results
        $this->checkResults($results, 1, 0, 0);

        // Find Product
        $model = Product::where('sku', $data['sku'])->first();

        // Assert Categories
        $this->assertEquals(2, $model->categories()->count(), 'Categories does not created');
    }

    /**
     *
     */
    public function test_import_product_properties()
    {
        // Prepare Import data
        $data = array_merge(self::$data, [
            'properties' => 'test_property::Test Value 1|test_property::Test Value 2',
        ]);

        // Run Import
        $results = $this->runImport($data);

        // Check ProductImport results
        $this->checkResults($results, 1, 0, 0);

        // Find Product
        $product = Product::where('sku', $data['sku'])->first();

        // Find Property
        $property = Property::where('code', 'test_property')->first();

        // Assert Product Properties
        $this->assertEquals(1, $product->properties()->count(), 'Product Properties does not attached');
        $this->assertEquals(2, $property->values()->count(), 'PropertyValues does not created');
    }

    //
    //
    //

    /**
     * Run ProductImport
     *
     * @param $data
     * @return object
     */
    private function runImport($data)
    {
        $importModel = new ProductImport;
        $importModel->importData([$data]);

        return $importModel->getResultStats();
    }

    /**
     * Check ProductImport results
     *
     * @param object $results
     * @param int $created
     * @param int $updated
     * @param int $errors
     */
    private function checkResults($results, $created, $updated, $errors)
    {
        $this->assertEquals($results->created, $created);
        $this->assertEquals($results->updated, $updated);
        $this->assertEquals($results->errorCount, $errors);
    }
}