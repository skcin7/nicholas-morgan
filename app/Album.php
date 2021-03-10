<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image as InverventionImage;
use Storage;

class Album extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'albums';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'title' => '',
        'artist' => '',
        'year' => '',
        'blurb' => '',
    ];

    /**
     * Attributes to cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'artist' => 'string',
        'year' => 'string',
        'blurb' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'artist',
        'year',
        'blurb',
    ];

    /**
     * Set the blurb attribute.
     *
     * @param string $value
     * @return $this
     */
    public function setBlurbAttribute($value)
    {
        $this->attributes['blurb'] = (string) $value; // In case of null, cast it to a string (always ensures it's a string - disallows being saved as null)

        return $this;
    }

    /**
     * Get the count of albums.
     *
     * @return mixed
     */
    public static function getCount()
    {
        return self::count();
    }

    /**
     * Get the slug to represent this album.
     *
     * @return string
     */
    public function getSlug()
    {
        return slugify($this->id . '-' . $this->artist . '-' . $this->title);
    }

    /**
     * Upload and process the cover
     *
     * @param $imageSource
     */
    public function uploadCover($imageSource)
    {
        if(! $this->exists) {
            $this->save(); // Ensures the ID exists which is a requirement for the slug
        }

        $interventionImage = InverventionImage::make($imageSource);

        // Process the cover at the original size:
        Storage::disk('public')->put(
            'images/albums/' . $this->getSlug() . '-original.jpg',
            $interventionImage
                ->encode('jpg')
        );

        // Process the cover at the converted size:
        Storage::disk('public')->put(
            'images/albums/' . $this->getSlug() . '.jpg',
            $interventionImage
                ->resize(500, null, function($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('jpg')
        );
    }

    /**
     * Remove the cover
     *
     * @return void
     */
    public function removeCover()
    {
        foreach([
            'images/albums/' . $this->getSlug() . '.jpg',
            'images/albums/' . $this->getSlug() . '-original.jpg',
        ] as $path_to_delete) {
            if(Storage::disk('public')->exists($path_to_delete)) {
                Storage::disk('public')->delete($path_to_delete);
            }
        }
    }

    /**
     * Get the public URL of the album's cover
     *
     * @param bool $original
     * @return mixed
     */
    public function getCoverUrl($original = false)
    {
        $path = 'images/albums/' . $this->getSlug() . ($original ? '-original' : '') . '.jpg';
        if(Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        // Failsafe
        return asset('images/no_image.png');
    }

    /**
     * Get the image file path of the album's cover
     *
     * @param bool $original
     * @return string
     */
    public function getCoverPath($original = false)
    {
        return storage_path('app/public/images/albums/' . $this->getUrl() . ($original ? '-original' : '') . '.jpg');
    }

    /**
     * Delete the album.
     *
     * @return bool|void|null
     * @throws \Exception
     */
    public function delete()
    {
        // Ensure that the cover file(s) are deleted too
        $this->removeCover();

        // Delete the record from the database
        parent::delete();
    }

}
