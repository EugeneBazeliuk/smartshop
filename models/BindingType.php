<?php namespace Smartshop\Catalog\Models;

use Model;
use Cms\Classes\Page;

/**
 * BindingType Model
 *
 * @property \October\Rain\Database\Collection bindings
 *
 * @method \October\Rain\Database\Relations\HasMany bindings
 */
class BindingType extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_binding_types';

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
        'page',
        'description',
    ];

    /**
     * @var string The database timestamps.
     */
    public $timestamps = false;

    /**
     * @var array Relations HasMany
     */
    public $hasMany = [
        'bindings' => [
            Binding::class
        ]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        // Base
        'name'  => 'required|max:255',
        'code'  => [
            'required',
            'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i',
            'unique:smartshop_binding_types'
        ],
        'page' => 'required|max:255',
        'description' => '',
    ];

    //
    // Options
    //
    public function getPageOptions()
    {
        return Page::sortBy('baseFileName')
            ->lists('title', 'baseFileName');
    }

    //
    //
    //

    public static function getNameList()
    {
        return self::lists('name', 'id');
    }
}
