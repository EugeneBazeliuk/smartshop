<?php namespace SmartShop\Catalog\Seeders;

use Smartshop\Catalog\Models\Category;

class CategorySeeder extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        $category1 = Category::create([
            // Base
            'name' => 'First Category',
            'slug' => 'first-category-slug',
            'description' => '<b>Test Description</b>',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);

        $category2 = Category::create([
            // Base
            'name' => 'Second Category',
            'slug' => 'second-category-slug',
            'description' => '<b>Test Description</b>',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);
    }
}