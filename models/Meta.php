<?php namespace SmartShop\Catalog\Models;

use Model;

/**
 * Meta Model
 *
 * @property int $id
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $canonical_url
 * @property string|null $redirect_url
 * @property string|null $robot_index
 * @property string|null $robot_follow
 * @property int|null $taggable_id
 * @property string|null $taggable_type
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereCanonicalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereRedirectUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereRobotFollow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereRobotIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereTaggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\SmartShop\Catalog\Models\Meta whereTaggableType($value)
 */
class Meta extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_catalog_meta';

    /**
     * @var bool The timestamps state
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
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'redirect_url',
        'robot_index',
        'robot_follow'
    ];

    /**
     * @var array $morphTo Relations
     */
    public $morphTo = [
        'taggable' => []
    ];

    /** @var array Validation rules */
    public $rules = [
        // Base
        'meta_title' => ['nullable', 'max:255'],
        'meta_keywords' => ['nullable', 'max:255'],
        'meta_description' => ['nullable', 'max:255'],
        'canonical_url' => ['nullable', 'max:255'],
        'redirect_url' => ['nullable', 'max:255'],
        'robot_index' => ['nullable', 'in:index,noindex'],
        'robot_follow' => ['nullable', 'in:follow,nofollow']
    ];
}
