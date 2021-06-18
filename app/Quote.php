<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'quotes';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'quote' => '',
        'author' => '',
        'is_public' => false,
    ];

    /**
     * Attributes to cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'quote' => 'string',
        'author' => 'string',
        'is_public' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'quote',
        'author',
        'is_public',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * Relationships to always be eager-loaded
     *
     * @var array
     */
    protected $with = [
        //
    ];

    /**
     * Relationships which can be included for eager loading.
     *
     * @var array
     */
    public static $availableIncludes = [
        //
    ];

    /**
     * Get the available relationships that can be included for eager-loading.
     *
     * @return array
     */
    public static function getAvailableIncludes()
    {
        return self::$availableIncludes;
    }

    /**
     * The validation rules that all valid release records must pass
     *
     * @var \string[][]
     */
    public static $validationRules = [
        'quote' => [
            'required',
            'string',
            'min:1',
        ],
        'author' => [
            'required',
            'string',
            'min:1',
            'max:255',
        ],
        'is_public' => [
            'required',
            'boolean',
        ],
    ];

    /**
     * Get the validation rules that all valid records must pass.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return self::$availableIncludes;
    }
}
