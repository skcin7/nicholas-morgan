<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image;
use Storage;

class Avatar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'avatars';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'summary' => '',
        'filename' => '',
        'is_current' => false,
    ];

    /**
     * Attributes to cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'summary' => 'string',
        'filename' => 'string',
        'is_current' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'summary',
        'filename',
        'is_current',
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
            'nullable',
            'string',
            'min:1',
            'max:255',
        ],
        'summary' => [
            'nullable',
            'string',
            'min:1',
            'max:1024',
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
        //
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
     * If the avatar is the current one.
     *
     * @return bool
     */
    public function isCurrent()
    {
        return (bool) $this->is_current;
    }

    public function getFormat($format = 'original')
    {
//        switch($format) {
//            case 'original':
//            case '':
//            default:
//                break;
//        }
        if($format === "original") {
            return asset('storage/avatars/' . $this->filename);
        }



        if($format === "xs") {
            $filename_xs = str_replace(".jpg", "_xs.jpg", $this->filename);

            // If the formatted image hasn't already been created/processed, then process it now before getting the format.
            if(! Storage::disk('public')->exists('avatars/' . $filename_xs)) {
                //            dd(Storage::disk('public')->path('avatars/' . $this->filename));
                $img = Image::make(Storage::disk('public')->path('avatars/' . $this->filename));

                Storage::disk('public')->put(
                    'avatars/' . $filename_xs,
                    $img
                        ->fit(50)
                        ->encode('jpg')
                );
            }

            return asset('storage/avatars/' . $filename_xs);
        }

        if($format === "sm") {
            $filename_sm = str_replace(".jpg", "_sm.jpg", $this->filename);

            // If the formatted image hasn't already been created/processed, then process it now before getting the format.
            if(! Storage::disk('public')->exists('avatars/' . $filename_sm)) {
                //            dd(Storage::disk('public')->path('avatars/' . $this->filename));
                $img = Image::make(Storage::disk('public')->path('avatars/' . $this->filename));

                Storage::disk('public')->put(
                    'avatars/' . $filename_sm,
                    $img
                        ->fit(100)
                        ->encode('jpg')
                );
            }

            return asset('storage/avatars/' . $filename_sm);
        }

        if($format === "md") {
            $filename_md = str_replace(".jpg", "_md.jpg", $this->filename);

            // If the formatted image hasn't already been created/processed, then process it now before getting the format.
            if(! Storage::disk('public')->exists('avatars/' . $filename_md)) {
                //            dd(Storage::disk('public')->path('avatars/' . $this->filename));
                $img = Image::make(Storage::disk('public')->path('avatars/' . $this->filename));

                Storage::disk('public')->put(
                    'avatars/' . $filename_md,
                    $img
                        ->fit(250)
                        ->encode('jpg')
                );
            }

            return asset('storage/avatars/' . $filename_md);
        }
    }

    public function delete()
    {
        $filenames_to_delete = [];
        $filenames_to_delete[] = $this->filename;
        $filenames_to_delete[] = str_replace('.jpg', '_xs.jpg', $this->filename);
        $filenames_to_delete[] = str_replace('.jpg', '_sm.jpg', $this->filename);
        $filenames_to_delete[] = str_replace('.jpg', '_md.jpg', $this->filename);

        foreach($filenames_to_delete as $filename) {
            $path = 'avatars/' . $filename;

            if(Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        // Delete the record from the database...
        parent::delete();
    }
}
