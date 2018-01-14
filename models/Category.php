<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * Category Model
 *
 * @property \SmartShop\Catalog\Models\Meta $meta
 *
 * @method \October\Rain\Database\Relations\MorphOne meta
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_categories';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        // Base
        'name',
        'slug',
        'description',
        // States
        'is_active',
        'is_searchable',
    ];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];

    /**
     * @var array Dates fields
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array Relations BelongToMany
     */
    public $belongsToMany = [
        'products' => [Product::class, 'table' => 'smartshop_categories_products'],
        'products_count' => [Product::class, 'table' => 'smartshop_categories_products', 'count' => true]
    ];

    /**
     * @var array Relations MorphOne
     */
    public $morphOne = [
        'meta' => ['Smartshop\Catalog\Models\Meta', 'name' => 'taggable'],
    ];

    /**
     * @var array Relations AttachOne
     */
    public $attachOne = [
        'image' => 'System\Models\File'
    ];



    /** @var array Validation rules */
    public $rules = [
        // Base
        'name'  => ['required', 'max:255'],
        'slug'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'max:255', 'unique:smartshop_categories'],
        'description'   => ['nullable'],
        // States
        'is_active'     => ['boolean'],
        'is_searchable' => ['boolean'],
    ];

    //
    //
    //

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param \Cms\Classes\Controller $controller
     * @return string
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id'   => $this->id,
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }
}