<?php

namespace App\Http\Resources;

class Album extends MyResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->processResource([
            'id' => $this->id,
            'slug' => $this->getSlug(),
            'title' => $this->title,
            'artist' => $this->artist,
            'year' => $this->year,
            'blurb' => $this->blurb,
            'cover' => $this->getCoverUrl(),
        ]);
    }
}
