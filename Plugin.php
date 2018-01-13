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
                    ]
                ]
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
            ]
        ];
    }
}