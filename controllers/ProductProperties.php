<?php namespace Smartshop\Catalog\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;

/**
 * Product Properties Back-end Controller
 *
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 * @mixin \Backend\Behaviors\RelationController
 */
class ProductProperties extends Controller
{
    /**
     * @var array Extensions implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class
    ];

    /**
     * @var array FormController configuration.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var array ListController configuration.
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array RelationController configuration.
     */
    public $relationConfig = 'config_relation.yaml';

    /**
     * ProductProperties constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Smartshop.Catalog', 'product_properties');
    }
}
