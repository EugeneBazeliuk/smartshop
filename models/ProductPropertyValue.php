<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * ProductPropertyValue Model
 */
class ProductPropertyValue extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_product_property_values';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'value'
    ];

    /**
     * @var string The database timestamps.
     */
    public $timestamps = false;

    /**
     * @var array Relations BelongTo
     */
    public $belongsTo = [
        'product_property' => [
            ProductProperty::class,
        ],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'value' => ['required', 'max:255'],
    ];
}