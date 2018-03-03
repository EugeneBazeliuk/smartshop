<?php namespace Smartshop\Catalog\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Smartshop\Catalog\Models\ImportTemplate;

/**
 * Import Templates Back-end Controller
 *
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 */
class ImportTemplates extends Controller
{
    /**
     * @var array Extensions implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
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
     * @var array Permissions required to view this page.
     */
    public $requiredPermissions = ['smartshop.catalog.access_import_templates'];

    /**
     * ImportTemplates constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Smartshop.Catalog', 'import_templates');
    }

    //
    //
    //

    /**
     * Extend Form refresh data
     *
     * @param \Backend\Widgets\Form $widget
     * @param array $data
     *
     * @return array
     */
    public function formExtendRefreshData($widget, $data)
    {
        $model = new ImportTemplate;

        $file = $model
            ->file()
            ->withDeferred($widget->getSessionKey())
            ->orderBy('id', 'desc')
            ->first();

        if ($file) {
            $data['mapping'] = $model->getFileMapping($file);
        }

        return $data;
    }
}
