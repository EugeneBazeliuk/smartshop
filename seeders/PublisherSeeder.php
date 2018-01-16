<?php namespace SmartShop\Catalog\Seeders;

use Smartshop\Catalog\Models\Publisher;

class PublisherSeeder extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        $publisher = Publisher::create([
            // Base
            'name' => 'First Publisher',
            'slug' => 'first-publisher-slug',
            'description' => '<b>Test Description</b>',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);
    }
}