<?php namespace Djetson\Shop\Tests\Models;

use PluginTestCase;
use SmartShop\Catalog\Models\Meta;
use Smartshop\Catalog\Models\Product;

/**
 * Class MetaModelTest
 */
class ProductModelTest extends PluginTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testCreateProduct()
    {
        $meta = Meta::create([
            'meta_title' => 'Test meta title',
            'meta_description' => 'Test meta description',
            'meta_keywords' => 'Test meta keywords',
        ]);

        Product::truncate();

        $product = new Product;
        // Base
        $product->title = "Test Product";
        $product->slug = "product-slug";
        $product->sku = "123456";
        $product->isbn = "12345678";
        $product->price = 100.00;
        $product->description = "<b>Test Product Description</b>";
        // Sizes
        $product->width = 10.11;
        $product->height = 11.12;
        $product->depth = 12.13;
        $product->weight = 13.14;

        // State
        $product->is_active = true;
        $product->is_searchable = true;
        $product->is_unique_text = true;

        // Meta Relation
        $product->meta = $meta;
        $product->save();

        // Base
        $this->assertEquals(1, $product->id);
        $this->assertEquals('Test Product', $product->title);
        $this->assertEquals('product-slug', $product->slug);
        $this->assertEquals('123456', $product->sku);
        $this->assertEquals('12345678', $product->isbn);
        $this->assertEquals(100.00, $product->price);
        $this->assertEquals('<b>Test Product Description</b>', $product->description);
        // Sizes
        $this->assertEquals(10.11, $product->width);
        $this->assertEquals(11.12, $product->height);
        $this->assertEquals(12.13, $product->depth);
        $this->assertEquals(13.14, $product->weight);
        // State
        $this->assertEquals(true, $product->is_active);
        $this->assertEquals(true, $product->is_searchable);
        $this->assertEquals(true, $product->is_unique_text);
        // Meta
        $this->assertEquals('Test meta title', $product->meta->meta_title);
        $this->assertEquals('Test meta description', $product->meta->meta_description);
        $this->assertEquals('Test meta keywords', $product->meta->meta_keywords);
    }
}