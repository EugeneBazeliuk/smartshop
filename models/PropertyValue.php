<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * PropertyValue Model
 *
 * @property \Smartshop\Catalog\Models\Property $property
 *
 * @method \October\Rain\Database\Relations\BelongsTo property
 *
 * @todo Обратное удаление для ProductToBinding
 */
class PropertyValue extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_property_values';

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
        'property' => [
            Property::class,
        ],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'value' => 'required|max:255',
    ];
}
