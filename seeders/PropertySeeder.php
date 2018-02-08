<?php namespace SmartShop\Catalog\Seeders;

use Smartshop\Catalog\Models\Property;

class PropertySeeder extends \October\Rain\Database\Updates\Seeder
{
    protected $property = [
        // Base
        'name' => 'First product property',
        'code' => 'first-property-code',
        'description' => 'Property description',
        // States
        'is_active' => true,
    ];

    protected $propertyValues = [
        'Value 1',
        'Value 2',
        'Value 3',
        'Value 4',
        'Value 5'
    ];

    public function run()
    {
        $property = new Property;
        $property->fill($this->property);
        $property->save();

        foreach ($this->propertyValues as $value) {
            $property->values()->create([
                'value' => $value
            ]);
        }
    }
}