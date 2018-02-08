<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * Product Model
 *
 * @property \October\Rain\Database\Collection $bindings
 * @property \October\Rain\Database\Collection $categories
 * @property \October\Rain\Database\Collection $properties
 * @property \SmartShop\Catalog\Models\Publisher $publisher
 * @property \SmartShop\Catalog\Models\PublisherSet $publisher_set
 * @property \Smartshop\Catalog\Models\Meta $meta
 * @property \System\Models\File $image
 *
 * @method \October\Rain\Database\Relations\BelongsTo publisher
 * @method \October\Rain\Database\Relations\BelongsTo publisher_set
 * @method \October\Rain\Database\Relations\BelongsToMany bindings
 * @method \October\Rain\Database\Relations\BelongsToMany categories
 * @method \October\Rain\Database\Relations\BelongsToMany properties
 * @method \October\Rain\Database\Relations\MorphOne meta
 * @method \October\Rain\Database\Relations\AttachOne image
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_products';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        // Base
        'title',
        'slug',
        'sku',
        'isbn',
        'price',
        'description',
        // Sizes
        'width',
        'height',
        'depth',
        'weight',
        // States
        'is_active',
        'is_searchable',
        'is_unique_text'
    ];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'title'];

    /**
     * @var array Dates fields
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array Relations BelongTo
     */
    public $belongsTo = [
        'publisher' => [Publisher::class],
        'publisher_set' => [PublisherSet::class],
    ];

    /**
     * @var array Relations BelongToMany
     */
    public $belongsToMany = [
        'bindings' => [
            Binding::class,
            'table' => 'smartshop_product_binding'
        ],
        'categories' => [
            Category::class,
            'table' => 'smartshop_product_category',
        ],
        'properties' => [
            Property::class,
            'table' => 'smartshop_product_property',
            'pivot'    => ['property_value_id'],
            'pivotModel' => ProductPropertyPivot::class
        ]
    ];

    /**
     * @var array Relations MorphOne
     */
    public $morphOne = [
        'meta' => [Meta::class, 'name' => 'taggable'],
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
        'title' => ['required', 'max:255'],
        'slug'  => ['required:update', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'max:255', 'unique:smartshop_products'],
        'sku'   => ['required', 'numeric', 'unique:smartshop_products'],
        'isbn'  => ['alpha_dash', 'max:25', 'unique:smartshop_products'],
        'price' => ['required', 'numeric'],
        // Sizes
        'width'     => ['numeric'],
        'height'    => ['numeric'],
        'depth'     => ['numeric'],
        'weight'    => ['numeric'],
    ];

    //
    // Options
    //

    /**
     * Get Publisher Options
     * @return array
     */
    public function getPublisherOptions()
    {
        return Publisher::getNameList();
    }

    /**
     * Get Publisher Set Options
     * @param $value
     * @param $data self
     * @return array
     */
    public function getPublisherSetOptions($value, $data)
    {
        return PublisherSet::getNameList($data->publisher_id);
    }

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
