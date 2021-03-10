<?php

namespace App\Http\Resources;

class User extends MyResource
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
            'username' => $this->name,
            'email' => $this->email,
        ]);
    }
}
