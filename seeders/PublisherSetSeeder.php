<?php namespace SmartShop\Catalog\Seeders;

use Smartshop\Catalog\Models\PublisherSet;

class PublisherSetSeeder extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        $publisher = PublisherSet::create([
            // Base
            'name' => 'First Publisher Set',
            'description' => '<b>Test Description</b>',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);
    }
}