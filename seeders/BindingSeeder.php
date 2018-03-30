<?php namespace SmartShop\Catalog\Seeders;

use Smartshop\Catalog\Models\Binding;
use SmartShop\Catalog\Models\BindingType;

class BindingSeeder extends \October\Rain\Database\Updates\Seeder
{
    protected $bindings = [
        // Base
        'name' => 'First Binding',
        'slug' => 'first-binding-slug',
        'description' => '<b>Test Description</b>',
        // States
        'is_active' => true,
        'is_searchable' => true,
    ];

    protected $bindingType = [
        // Base
        'name' => 'First Binding Type',
        'code' => 'first-binding-type',
        'page' => 'test/page',
    ];

    public function run()
    {
        $binding = Binding::make($this->bindings);
        $binding->binding_type = BindingType::create($this->bindingType);
        $binding->save();

        BindingType::create([
            'name' => 'Автор',
            'code' => 'author',
        ]);

        BindingType::create([
            'name' => 'Noname',
            'code' => 'Artist',
        ]);

        BindingType::create([
            'name' => 'Переводчик',
            'code' => 'Translater',
        ]);

        BindingType::create([
            'name' => 'Редактор',
            'code' => 'Editor',
        ]);
    }
}