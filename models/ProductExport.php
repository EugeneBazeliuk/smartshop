<?php namespace Smartshop\Catalog\Models;

/**
 * ProductExport Model
 *
 * @property \SmartShop\Catalog\Models\Publisher $product_publisher
 * @property \SmartShop\Catalog\Models\PublisherSet $product_publisher_set
 * @property \October\Rain\Database\Collection $product_categories
 * @property \October\Rain\Database\Collection $product_properties
 *
 * @method \October\Rain\Database\Relations\BelongsTo product_publisher
 * @method \October\Rain\Database\Relations\BelongsTo product_publisher_set
 * @method \October\Rain\Database\Relations\BelongsToMany product_categories
 * @method \October\Rain\Database\Relations\BelongsToMany product_properties
 */
class ProductExport extends \Backend\Models\ExportModel
{
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
        'format_delimiter_level_2',
    ];



    /**
     * The accessors to append to the model's array form.
     * @var array
     */
    protected $appends = [
        'publisher',
        'publisher_set',
        'categories',
        'properties'
    ];

    /**
     * @var array Relations BelongTo
     */
    public $belongsTo = [
        'product_publisher' => [
            Publisher::class,
            'key' => 'publisher_id'
        ],
        'product_publisher_set' => [
            PublisherSet::class,
            'key' => 'publisher_set_id'
        ],
    ];

    /**
     * @var array Relations BelongToMany
     */
    public $belongsToMany = [
        'product_categories' => [
            Category::class,
            'table' => 'smartshop_category_product',
            'key' => 'product_id',
            'otherKey' => 'category_id',
        ],
        'product_properties' => [
            ProductProperty::class,
            'table' => 'smartshop_product_property',
            'key'      => 'product_id',
            'otherKey' => 'property_id',
            'pivot'    => ['property_value_id'],
            'pivotModel' => ProductPropertyPivot::class
        ]
    ];

    //
    // Export
    //

    /**
     * Export Data
     * @param      $columns
     * @param null $sessionKey
     *
     * @return array
     */
    public function exportData($columns, $sessionKey = null)
    {
        $products = new self();

        $f = $products->with([
            'product_publisher',
            'product_publisher_set',
            'product_categories',
            'product_properties'
        ])->get()->each(function($product) use ($columns) {
            $product->addVisible($columns);
        })->toArray();

        return $f;
    }

    //
    // Attributes
    //

    /**
     * Get Publisher attribute
     * @return string
     */
    public function getPublisherAttribute()
    {
        return $this->product_publisher ? $this->product_publisher->name : '';
    }

    /**
     * Get PublisherSet attribute
     * @return string
     */
    public function getPublisherSetAttribute()
    {
        return $this->product_publisher_set ? $this->product_publisher_set->name : '';
    }

    /**
     * Get Categories attribute
     * @return string
     */
    public function getCategoriesAttribute()
    {
        return $this->product_categories->count()
            ? $this->encodeArrayValue($this->product_categories->pluck('name'))
            : '';
    }

    /**
     * Get properties attribute
     */
    public function getPropertiesAttribute()
    {
        if (!$this->product_properties->count()) {
            return [];
        }

        $properties = [];

        $this->product_properties->each(function ($property) use (&$properties) {
            $properties[] = $this->encodeArrayValue([
                $property->code,
                ProductPropertyValue::whereId($property->pivot->property_value_id)
                    ->value('value')
            ], '::');
        });

        return $this->encodeArrayValue($properties);
    }
}
