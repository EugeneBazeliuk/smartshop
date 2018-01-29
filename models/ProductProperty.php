<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * ProductProperty Model
 *
 * @property \October\Rain\Database\Collection $values
 * @property \October\Rain\Database\Collection $products
 *
 * @method \October\Rain\Database\Relations\HasMany values
 * @method \October\Rain\Database\Relations\BelongsToMany products
 *
 * @mixin \October\Rain\Database\Traits\Sluggable
 * @mixin \October\Rain\Database\Traits\Validation
 */
class ProductProperty extends Model
{
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_product_properties';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = [
        'code' => 'name'
    ];

    /**
     * @var string The database timestamps.
     */
    public $timestamps = false;

    /**
     * @var array Relations
     */
    public $hasMany = [
        'values' => [
            \SmartShop\Catalog\Models\ProductPropertyValue::class
        ],
    ];

    /**
     * @var array Relations BelongToMany
     */
    public $belongsToMany = [
        'products' => [
            Product::class,
            'table' => 'smartshop_product_property',
            'key'      => 'property_id',
            'otherKey' => 'product_id',
            'pivot'    => ['property_value_id'],
        ]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        // Base
        'name'  => ['required', 'max:255'],
        'code'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'max:255', 'unique:smartshop_product_properties'],
        'description' => [],
        // States
        'is_active'   => ['boolean'],
    ];

    /**
     * Get Property Values List
     * @return array
     */
    public function getValuesList()
    {
        return ProductPropertyValue::whereProductPropertyId($this->id)->only('value', 'id');
    }
}