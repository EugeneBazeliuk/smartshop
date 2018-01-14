<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * Product Model
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $sku
 * @property string|null $isbn
 * @property float $price
 * @property string|null $description
 * @property float|null $width
 * @property float|null $height
 * @property float|null $depth
 * @property float|null $weight
 * @property int $is_active
 * @property int $is_searchable
 * @property int $is_unique_text
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereIsSearchable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereIsUniqueText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Smartshop\Catalog\Models\Product whereWidth($value)
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_catalog_products';

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
     * @var array Relations
     */
    public $morphOne = [
        'meta' => ['Smartshop\Catalog\Models\Meta', 'name' => 'taggable'],
    ];

    /** @var array Validation rules */
    public $rules = [
        // Base
        'title' => ['required', 'max:255'],
        'slug'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'max:255', 'unique:smartshop_catalog_products'],
        'sku'   => ['required', 'numeric', 'unique:smartshop_catalog_products'],
        'isbn'  => ['alpha_dash', 'max:25', 'unique:smartshop_catalog_products'],
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
