<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WritingCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'writings_categories';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
    ];

    /**
     * Attributes to cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
     * The validation rules that all valid records must pass
     *
     * @var \string[][]
     */
    public static $validationRules = [
        'name' => [
            'required',
            'string',
            'min:1',
            'max:255',
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
        'writings',
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
     * A writing category has many writings that are filed under the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function writings()
    {
        return $this->belongsToMany('App\Writing', 'writings_writings_categories');
    }

    /**
     * Delete a writing category.
     *
     * @return bool|void|null
     */
    public function delete()
    {
        // Detach all attached writings to prepare it to be deleted.
        $this->writings()->detach();

        parent::delete();
    }
}
