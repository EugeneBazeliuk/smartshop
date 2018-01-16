<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * Product Model
 *
 * @property \October\Rain\Database\Collection $categories
 * @property \Smartshop\Catalog\Models\Meta $meta
 * @property \System\Models\File $image
 *
 * @method \October\Rain\Database\Relations\BelongToMany categories
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
     * @var array Relations
     */
    public $belongsToMany = [
        'categories' => [Category::class, 'table' => 'smartshop_categories_products']
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
        'slug'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'max:255', 'unique:smartshop_products'],
        'sku'   => ['required', 'numeric', 'unique:smartshop_products'],
        'isbn'  => ['alpha_dash', 'max:25', 'unique:smartshop_products'],
        'description' => ['nullable'],
        // Sizes
        'width'     => ['nullable', 'numeric'],
        'height'    => ['nullable', 'numeric'],
        'depth'     => ['nullable', 'numeric'],
        'weight'    => ['nullable', 'numeric'],
        // States
        'is_active'         => ['boolean'],
        'is_searchable'     => ['boolean'],
        'is_unique_text'    => ['boolean'],
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
