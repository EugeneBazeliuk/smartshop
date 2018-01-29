<?php namespace Smartshop\Catalog\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use SmartShop\Catalog\Models\Meta;
use Smartshop\Catalog\Models\Product;

/**
 * Products Back-end Controller
 *
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 * @mixin \Backend\Behaviors\RelationController
 * @mixin \Backend\Behaviors\ImportExportController
 */
class Products extends Controller
{
    /**
     * @var array Extensions implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class,
        \Backend\Behaviors\ImportExportController::class
    ];

    /**
     * @var array `FormController` configuration.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var array `ListController` configuration.
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array RelationController configuration, by extension.
     */
    public $relationConfig = 'config_relation.yaml';

    /**
     * @var array ImportExportController configuration.
     */
    public $importExportConfig = 'config_import_export.yaml';

    /**
     * @var array Permissions required to view this page.
     */
    public $requiredPermissions = ['smartshop.catalog.access_products'];

    /**
     * @var string HTML body tag class
     */
    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Smartshop.Catalog', 'catalog', 'products');
    }

    /**
     *
     */
    public function index()
    {
        $model = new Product;

        $this->vars['scoreboard'] = [
            'count_is_active' => $model->where('is_active', 1)->count(),
            'count_is_disabled' => $model->where('is_active', 0)->count(),
            'count_is_deleted' => $model->onlyTrashed()->count(),
        ];

        return $this->asExtension('ListController')->index();
    }

    /**
     *
     */
    public function export()
    {
        $this->bodyClass = '';
        $this->asExtension('ImportExportController')->export();
    }

    /**
     *
     */
    public function import()
    {
        $this->bodyClass = '';
        $this->asExtension('ImportExportController')->import();
    }


    /**
     * Extend Form Model
     * @param $model
     * @return mixed
     */
    public function formExtendModel($model)
    {
        if (!$model->meta) {
            $model->meta = new Meta;
        }

        return $model;
    }
}