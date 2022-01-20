<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Writing extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'writings';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'title' => '',
        'body_html' => '',
        'css' => '',
        'is_published' => false,
        'is_hidden' => false,
        'is_unlisted' => false,
    ];

    /**
     * Attributes to cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'body_html' => 'string',
        'css' => 'string',
        'is_published' => 'boolean',
        'is_hidden' => 'boolean',
        'is_unlisted' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body_html',
        'css',
        'is_published',
        'is_hidden',
        'is_unlisted',
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
        //'categories',
    ];

    /**
     * The validation rules that all valid records must pass
     *
     * @var \string[][]
     */
    public static $validationRules = [
        'title' => [
            'required',
            'string',
            'min:1',
            'max:255',
        ],
        'body_html' => [
            'required',
            'string',
            'min:1',
            'max:65536',
        ],
        'css' => [
            'nullable',
            'string',
            'min:0',
            'max:65536',
        ],
        'is_published' => [
//            'present',
            'boolean',
        ],
        'is_hidden' => [
//            'present',
            'boolean',
        ],
        'is_unlisted' => [
//            'present',
            'boolean',
        ],
    ];

    /**
     * Get the validation rules that all valid release records must pass.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return self::$validationRules;
    }

    /**
     * Relationships which can be included for eager loading.
     *
     * @var array
     */
    public static $availableIncludes = [
        'categories',
    ];

    /**
     * Get the available relationships that may be included for eager-loading
     *
     * @return array
     */
    public static function getAvailableIncludes()
    {
        return self::$availableIncludes;
    }

    /**
     * If a writing is published, it shows up on the writings list, and may be viewed and read by the public.
     *
     * @return bool
     */
    public function isPublished()
    {
        return (bool) $this->is_published;
    }

    /**
     * A writing may be hidden from public view, which effectively is the same as it being unpublished, but 'hidden' lets it be not accessible by the public without having to change the published value.
     *
     * @return bool
     */
    public function isHidden()
    {
        return (bool) $this->is_hidden;
    }

    /**
     * A writing may be unlisted, which makes it not show up on the writings list, but may still be accessed by using the direct link.
     *
     * @return bool
     */
    public function isUnlisted()
    {
        return (bool) $this->is_unlisted;
    }

    /**
     * Get the slug to represent the writing.
     *
     * @return string
     */
    public function getSlug()
    {
        $to_slugify = ($this->id . ' ' . $this->title);
        return slugify($to_slugify);
    }

    /**
     * Get the count of active writings (which are public that any guest user may be able to read and has access to).
     *
     * @return mixed
     */
    public static function getActiveWritingsCount()
    {
        return self::where('is_published', true)
            ->where('is_hidden', false)
            ->count();
    }

    /**
     * A writing may be filed under many categories (or none).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\WritingCategory', 'writings_writings_categories');
    }

//    public function attachCategory($category)
//    {
//        $this->categories()->attach($category);
//    }
//
//    public function detachCategory($category)
//    {
//        $this->categories()->detach($category);
//    }
}
