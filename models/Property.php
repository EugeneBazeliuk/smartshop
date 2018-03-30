<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * Property Model
 *
 * @property \October\Rain\Database\Collection $values
 * @property \October\Rain\Database\Collection $products
 *
 * @method \October\Rain\Database\Relations\HasMany values
 * @method \October\Rain\Database\Relations\BelongsToMany products
 *
 * @mixin \Eloquent
 */
class Property extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_properties';

    /**
     * @var string The database timestamps.
     */
    public $timestamps = false;

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
     * @var array Relations
     */
    public $hasMany = [
        'values' => [
            PropertyValue::class
        ],
    ];

    /**
     * @var array Relations BelongToMany
     */
    public $belongsToMany = [
        'products' => [
            Product::class,
            'table' => 'smartshop_product_property',
        ]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        // Base
        'name'  => 'max:255',
        'code'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:smartshop_properties'],
        'description' => '',
        // States
        'is_active' => 'boolean',
    ];

    /**
     * Get Values Options
     */
    public function getValuesOptions()
    {
        return $this->values()->pluck('value', 'id');
    }
}
