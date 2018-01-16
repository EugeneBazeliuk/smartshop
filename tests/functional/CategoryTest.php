<?php

/**
 * Class CategoryTest
 */
class CategoryTest extends UiTestCase
{
    public $fields = [
        'name' => 'Test name',
        'slug' => 'test-slug',
    ];

    public function test_create_category()
    {
        $this->signInToBackend();
        $this->open('backend/smartshop/catalog/categories/create');
        $this->waitForPageToLoad(TEST_SELENIUM_TIMEOUT);

        // Check form
        try {
            // Check fields
            foreach ($this->fields as $name => $value) {
                $this->assertTrue($this->isElementPresent('name=Category['.$name.']'));
                $this->type('name=Category['.$name.']', $value);
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
