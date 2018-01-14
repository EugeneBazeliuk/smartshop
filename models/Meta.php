<?php namespace SmartShop\Catalog\Models;

use Model;

/**
 * Meta Model
 */
class Meta extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_meta';

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
