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
        'body' => '',
        'is_published' => false,
    ];

    /**
     * Attributes to cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'body' => 'string',
        'is_published' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        //'is_published',
    ];

    /**
     * Get the slug to represent the writing.
     *
     * @return string
     */
    public function getSlug()
    {
        return slugify($this->id . '-' . $this->title);
    }

    /**
     * Determine if the writing is published or not.
     *
     * @return bool
     */
    public function published()
    {
        return (bool) $this->is_published;
    }

    /**
     * Get the count of active writings (which are public that any guest user may be able to read and has access to).
     *
     * @return mixed
     */
    public static function getActiveCount()
    {
        return self::where('is_published', true)->count();
    }
}
