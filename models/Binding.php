<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * Binding Model
 *
 * @mixin \Eloquent
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property boolean $is_active
 * @property boolean $is_searchable
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \SmartShop\Catalog\Models\BindingType $binding_type
 * @property \October\Rain\Database\Collection $products
 * @property \SmartShop\Catalog\Models\Meta $meta
 * @property \System\Models\File $image
 *
 * @method \October\Rain\Database\Relations\BelongsTo binding_type
 * @method \October\Rain\Database\Relations\BelongsToMany products
 * @method \October\Rain\Database\Relations\MorphOne meta
 * @method \October\Rain\Database\Relations\AttachOne image
 */
class Binding extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_bindings';

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
        // Relations
        'binding_type_id',
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
     * @var array Relations BelongTo
     */
    public $belongsTo = [
        'binding_type' => [
            BindingType::class
        ],
    ];

    /**
     * @var array Relations BelongToMany
     */
    public $belongsToMany = [
        'products' => [
            Product::class,
            'table' => 'smartshop_product_binding'
        ],
        'products_count' => [
            Product::class,
            'table' => 'smartshop_product_binding',
            'count' => true
        ]
    ];

    /**
     * @var array Relations MorphOne
     */
    public $morphOne = [
        'meta' => [
            Meta::class,
            'name' => 'taggable'
        ],
    ];

    /**
     * @var array Relations AttachOne
     */
    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        // Base
        'name'  => 'required|max:255',
        'slug'  => [
            'required:update',
            'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i',
            'max:255',
            'unique:smartshop_bindings'
        ],
        'description' => '',
        // Relations
        'binding_type' => 'required',
        // States
        'is_active'     => 'boolean',
        'is_searchable' => 'boolean',
    ];

    //
    // Options
    //

    public function getBindingTypeOptions()
    {
        return BindingType::getNameList();
    }
}
