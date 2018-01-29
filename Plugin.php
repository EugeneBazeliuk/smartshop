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
            'product_properties' => [
                'label'       => 'smartshop.catalog::lang.product_properties.menu_label',
                'description' => 'smartshop.catalog::lang.product_properties.menu_description',
                'category'    => 'smartshop.catalog::lang.plugin.name',
                'icon'        => 'icon-globe',
                'url'         => Backend::url('smartshop/catalog/productproperties'),
                'order'       => 500,
                'permissions' => ['smartshop.catalog.access_product_properties'],
                'keywords'    => 'product, properties',
            ],
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
            'smartshop.catalog.access_product_properties' => [
                'tab'   => 'smartshop.catalog::lang.plugin.tab',
                'label' => 'smartshop.catalog::lang.plugin.access_product_properties'
            ]
        ];
    }
}