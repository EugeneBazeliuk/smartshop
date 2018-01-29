<?php namespace SmartShop\Catalog\Seeders;

use Smartshop\Catalog\Models\ProductProperty;

class ProductPropertySeeder extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        $productProperty1 = ProductProperty::create([
            // Base
            'name' => 'First product property',
            'code' => 'first-property-code',
            'description' => 'Property description',
            // States
            'is_active' => true,
        ]);

        $productProperty2 = ProductProperty::create([
            // Base
            'name' => 'Second product property',
            'code' => 'second-property-code',
            'description' => 'Property description',
            // States
            'is_active' => true,
        ]);
    }
}