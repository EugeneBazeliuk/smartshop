<?php namespace SmartShop\Catalog\Seeders;

use Smartshop\Catalog\Models\Binding;

class BindingSeeder extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        $binding1 = Binding::create([
            // Base
            'name' => 'First Binding',
            'slug' => 'first-binding-slug',
            'description' => '<b>Test Description</b>',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);

        $binding2 = Binding::create([
            // Base
            'name' => 'Second Binding',
            'slug' => 'second-binding-slug',
            'description' => '<b>Test Description</b>',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);
    }
}