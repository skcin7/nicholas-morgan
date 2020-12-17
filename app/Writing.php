<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Writing extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
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
}
