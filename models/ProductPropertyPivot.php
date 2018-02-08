<?php namespace Smartshop\Catalog\Models;

use October\Rain\Database\Pivot;

/**
 * ProductPropertyPivot Model
 *
 * @property \Smartshop\Catalog\Models\Product $product
 * @property \Smartshop\Catalog\Models\Property $property
 * @property \Smartshop\Catalog\Models\PropertyValue $property_value
 *
 * @method \October\Rain\Database\Relations\BelongsTo product
 * @method \October\Rain\Database\Relations\BelongsTo property
 * @method \October\Rain\Database\Relations\BelongsTo property_value
 */
class ProductPropertyPivot extends Pivot
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_product_property';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations BelongTo
     */
    public $belongsTo = [
        'product' => [
            Product::class,
        ],
        'property' => [
            Property::class,
        ],
        'property_value' => [
            PropertyValue::class
        ],
    ];

    /** @var array Validation rules */
    public $rules = [
        'product' => ['required'],
        'property' => ['required'],
        'property_value' => ['required']
    ];

    /**
     * Get PropertyValue Options
     */
    public function getPropertyValueOptions($value, $data)
    {
        if (!$data instanceof Property) {
            return [];
        }

        return $data->getValuesOptions();
    }
}