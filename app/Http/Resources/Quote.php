<?php

namespace App\Http\Resources;

class Quote extends MyResource
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
            'quote' => $this->quote,
            'author' => $this->author,
            'is_public' => (boolean) $this->is_public,
        ]);
    }
}
