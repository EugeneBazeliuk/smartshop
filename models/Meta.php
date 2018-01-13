<?php namespace SmartShop\Catalog\Models;

use Model;

/**
 * Meta Model
 */
class Meta extends Model
{
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
}
