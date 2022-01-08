<?php

namespace App\Http\Resources;

class Bookmarklet extends MyResource
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
            'name' => $this->name,
            'javascript_code' => $this->javascript_code,
            'status' => $this->status,
        ]);
    }
}
