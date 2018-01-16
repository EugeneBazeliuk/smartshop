<?php

/**
 * Class PublisherTest
 */
class PublisherSetTest extends UiTestCase
{
    public $validPublisher = [
        'name' => 'Test name',
        'slug' => 'test-slug',
    ];

    public function test_create_publisher()
    {
        $this->signInToBackend();
        $this->open('backend/smartshop/catalog/publishersets/create');
        $this->waitForPageToLoad(TEST_SELENIUM_TIMEOUT);

        // Check form
        try {
            // Check fields
            foreach ($this->validPublisher as $name => $value) {
                $this->assertTrue($this->isElementPresent('name=PublisherSet['.$name.']'));
                $this->type('name=PublisherSet['.$name.']', $value);
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