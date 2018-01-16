<?php namespace Smartshop\Catalog\Models;

use Model;

/**
 * Publisher Model
 *
 * @property \October\Rain\Database\Collection $sets
 * @property \System\Models\File $image
 *
 * @method \October\Rain\Database\Relations\hasMany sets
 * @method \October\Rain\Database\Relations\AttachOne image
 */
class Publisher extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_publishers';

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
     * @var array Relations HasMany
     */
    public $hasMany = [
        'sets' => [
            PublisherSet::class
        ]
    ];

    /**
     * @var array Relations MorphOne
     */
    public $morphOne = [
        'meta' => ['Smartshop\Catalog\Models\Meta', 'name' => 'taggable'],
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
        'name'  => ['required', 'max:255'],
        'slug'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'max:255', 'unique:smartshop_publishers'],
        'description'   => ['nullable'],
        // States
        'is_active'     => ['boolean'],
        'is_searchable' => ['boolean'],
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