<?php namespace Smartshop\Catalog\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use SmartShop\Catalog\Models\Meta;
use SmartShop\Catalog\Models\Publisher;

/**
 * Publishers Back-end Controller
 *
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 * @mixin \Backend\Behaviors\RelationController
 */
class Publishers extends Controller
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
     * @var array RelationController configuration, by extension.
     */
    public $relationConfig = 'config_relation.yaml';

    /**
     * @var array Permissions required to view this page.
     */
    public $requiredPermissions = ['smartshop.catalog.access_publishers'];

    /**
     * @var string HTML body tag class
     */
    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Smartshop.Catalog', 'catalog', 'publishers');
    }

    /**
     *
     */
    public function index()
    {
        $model = new Publisher;

        $this->vars['scoreboard'] = [
            'count_is_active' => $model->where('is_active', 1)->count(),
            'count_is_disabled' => $model->where('is_active', 0)->count(),
            'count_is_deleted' => $model->onlyTrashed()->count(),
        ];

        $this->asExtension('ListController')->index();
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

    /**
     * @param Publisher $record
     * @param null $definition
     * @return string
     */
    public function listInjectRowClass($record, $definition = null)
    {
        if ($record->trashed()) {
            return 'strike';
        }

        return null;
    }

    /**
     * Extend list query
     * @param \October\Rain\Database\Builder|Publisher $query
     */
    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }



//    /**
//     * @param $config
//     * @param $field
//     * @param \Smartshop\Catalog\Models\PublisherSet $model
//     */
//    public function relationExtendConfig($config, $field, $model)
//    {
//        $model->withTrashed();
//    }
}
