<?php

/**
 * Class ProductsTest
 */
class ProductPropertyTest extends UiTestCase
{
    public $validProduct = [
        'name' => 'Test name',
        'code' => 'test-code',
        'description' => 'Test description'
    ];

    public function test_create_product()
    {
        $this->signInToBackend();
        $this->open('backend/smartshop/catalog/productproperties/create');
        $this->waitForPageToLoad(TEST_SELENIUM_TIMEOUT);

        // Check form
        try {
            // Check fields
            foreach ($this->validProduct as $name => $value) {
                $this->assertTrue($this->isElementPresent('name=ProductProperty['.$name.']'));
                $this->type('name=ProductProperty['.$name.']', $value);
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