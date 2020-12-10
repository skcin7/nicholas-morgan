<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Writing extends Model
{
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
