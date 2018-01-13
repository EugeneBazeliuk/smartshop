<?php

/**
 * Class ProductsTest
 */
class ProductsTest extends UiTestCase
{
    public $validProduct = [
        'title' => 'Test Product',
        'slug' => 'test-product',
        'sku' => '123456',
        'isbn' => '12345678',
        'price' => '110.12',
        'width' => '11.12',
        'height' => '12.13',
        'depth' => '13.14'
    ];

    public function test_create_product()
    {
        $this->signInToBackend();
        $this->open('backend/smartshop/catalog/products/create');
        $this->waitForPageToLoad(TEST_SELENIUM_TIMEOUT);

        // Check form
        try {
            // Check fields
            foreach ($this->validProduct as $name => $value) {
                $this->assertTrue($this->isElementPresent('name=Product['.$name.']'));
                $this->type('name=Product['.$name.']', $value);
            }
            // Create a product
            $this->click("xpath=(//button[@data-request='onSave'])[1]");
            // Delete a product
            $this->waitForElementPresent("xpath=(//button[@data-request='onDelete'])");
            $this->click("xpath=(//button[@data-request='onDelete'])[1]");
            $this->getSweetConfirmation();
        }
        catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }
}