<?php namespace SmartShop\Tests\Unit;

use PluginTestCase;
use SmartShop\Catalog\Models\Meta;
use Smartshop\Catalog\Models\Product;
use Smartshop\Catalog\Models\Category;
use Smartshop\Catalog\Models\Binding;
use Smartshop\Catalog\Models\BindingType;
use Smartshop\Catalog\Models\Property;

/**
 * Class MetaModelTest
 */
class ProductModelTest extends PluginTestCase
{
    public static $product = [
        // Base
        'title' => 'Test Product',
        'slug' => 'test-product-slug',
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

    private $propertyValue = 'Test Value';

    public function test_create_product()
    {
        Product::truncate();

        // Create model
        $model = new Product;
        $model->fill(self::$product);

        // Create Meta Relation
        $model->meta = new Meta();
        $model->meta->fill(MetaModelTest::$meta);

        // Save Model
        $model->save();

        // Create Category Relation
        $model->categories()->add($this->getCategoryModel());

        // Create Binding Relation
        $model->bindings()->add($this->getBindingModel());

        // Create Property Relation
        $property = $this->getPropertyModel();

        $propertyValue = $property->values()->create([
            'value' => $this->propertyValue
        ]);

        $model->properties()->attach($property->id, [
            'property_value_id' => $propertyValue->id
        ]);

        // Assert model id
        $this->assertEquals(1, $model->id);

        // Assert model attributes
        foreach (self::$product as $key => $val) {
            $this->assertEquals($val, $model->{$key});
        }

        // Assert model meta attributes
        foreach (MetaModelTest::$meta as $key => $val) {
            $this->assertEquals($val, $model->meta->{$key});
        }

        // Assert Related Categories Model
        $this->assertEquals(1, $model->categories()->count());

        // Assert Related Bindings Model
        $this->assertEquals(1, $model->bindings()->count());

        // Assert Related Properties Model
        $this->assertEquals(1, $model->properties()->count());
        $this->assertEquals(1, $model->properties->contains($property->id));
        $this->assertEquals($this->propertyValue, $model->properties->find($property->id)->pivot->property_value->value);
    }

    /**
     * @return \Smartshop\Catalog\Models\Category
     */
    private function getCategoryModel()
    {
        return Category::create(CategoryModelTest::$category);
    }

    /**
     * @return \Smartshop\Catalog\Models\Binding
     */
    private function getBindingModel()
    {
        $model = Binding::make(BindingModelTest::$binding);
        $model->binding_type = $this->getBindingTypeModel();
        $model->save();

        return $model;
    }

    /**
     * @return \Smartshop\Catalog\Models\BindingType
     */
    private function getBindingTypeModel()
    {
        return BindingType::create(BindingTypeModelTest::$bindingType);
    }

    /**
     * @return \Smartshop\Catalog\Models\Property
     */
    private function getPropertyModel()
    {
        return Property::create(PropertyModelTest::$property);
    }
}