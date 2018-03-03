<?php namespace Smartshop\Catalog;

use Backend;
use System\Classes\PluginBase;

/**
 * Catalog Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'smartshop.catalog::lang.plugin.name',
            'description' => 'smartshop.catalog::lang.plugin.description',
            'author'      => 'Eugene Baz',
            'icon'        => 'icon-leaf',
            'homepage'    => 'https://github.com/rainlab/user-plugin'
        ];
    }

    /**
     * Register plugin navigation
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'catalog' => [
                'label'       => 'smartshop.catalog::lang.plugin.menu_label',
                'url'         => Backend::url('smartshop/catalog/products'),
                'icon'        => 'icon-cube',
                'permissions' => ['smartshop.catalog.*'],
                'order'       => 500,
                'sideMenu' => [
                    'products' => [
                        'label'       => 'smartshop.catalog::lang.products.menu_label',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('smartshop/catalog/products'),
                        'permissions' => ['smartshop.catalog.access_products'],
                    ],
                    'categories' => [
                        'label'       => 'smartshop.catalog::lang.categories.menu_label',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('smartshop/catalog/categories'),
                        'permissions' => ['smartshop.catalog.access_categories'],
                    ],
                    'publishers' => [
                        'label'       => 'smartshop.catalog::lang.publishers.menu_label',
                        'icon'        => 'icon-book',
                        'url'         => Backend::url('smartshop/catalog/publishers'),
                        'permissions' => ['smartshop.catalog.access_publishers'],
                    ],
                    'publishersets' => [
                        'label'       => 'smartshop.catalog::lang.publisher_sets.menu_label',
                        'icon'        => 'icon-book',
                        'url'         => Backend::url('smartshop/catalog/publishersets'),
                        'permissions' => ['smartshop.catalog.access_publisher_sets'],
                    ],
                    'bindings' => [
                        'label'       => 'smartshop.catalog::lang.bindings.menu_label',
                        'icon'        => 'icon-book',
                        'url'         => Backend::url('smartshop/catalog/bindings'),
                        'permissions' => ['smartshop.catalog.access_bindings'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Register plugin settings
     * @return array
     */
    public function registerSettings()
    {
        return [
            'properties' => [
                'label'       => 'smartshop.catalog::lang.properties.menu_label',
                'description' => 'smartshop.catalog::lang.properties.menu_description',
                'category'    => 'smartshop.catalog::lang.plugin.name',
                'icon'        => 'icon-globe',
                'url'         => Backend::url('smartshop/catalog/properties'),
                'order'       => 200,
                'permissions' => ['smartshop.catalog.access_properties'],
                'keywords'    => 'product, property',
            ],
            'binding_types' => [
                'label'       => 'smartshop.catalog::lang.binding_types.menu_label',
                'description' => 'smartshop.catalog::lang.binding_types.menu_description',
                'category'    => 'smartshop.catalog::lang.plugin.name',
                'icon'        => 'icon-globe',
                'url'         => Backend::url('smartshop/catalog/bindingtypes'),
                'order'       => 200,
                'permissions' => ['smartshop.catalog.access_binding_types'],
                'keywords'    => 'binding, binding type',
            ],
            'import_templates' => [
                'label'       => 'smartshop.catalog::lang.import_templates.menu_label',
                'description' => 'smartshop.catalog::lang.import_templates.menu_description',
                'category'    => 'smartshop.catalog::lang.plugin.name',
                'icon'        => 'icon-globe',
                'url'         => Backend::url('smartshop/catalog/importtemplates'),
                'order'       => 200,
                'permissions' => ['smartshop.catalog.access_import_templates'],
                'keywords'    => 'import, import template',
            ]
        ];
    }

    /**
     * Register plugin permissions
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'smartshop.catalog.access_products' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_products'
            ],
            'smartshop.catalog.access_import_export' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_import_export'
            ],
            'smartshop.catalog.access_categories' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_categories'
            ],
            'smartshop.catalog.access_publishers' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_publishers'
            ],
            'smartshop.catalog.access_publisher_sets' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_publisher_sets'
            ],
            'smartshop.catalog.access_bindings' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_bindings'
            ],
            'smartshop.catalog.access_binding_types' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_binding_types'
            ],
            'smartshop.catalog.access_product_properties' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_product_properties'
            ],
            'smartshop.catalog.access_import_templates' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_import_templates'
            ]
        ];
    }
}