<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyResource extends JsonResource
{
    /**
     * Process the resource with hidden and whitelisted fields.
     *
     * @param array $data
     * @return array
     */
    protected function processResource(array $data)
    {
        // Attach created at/updated at datetime fields if they are present:
        if($this->created_at) {
            $data['createdAt'] = $this->created_at;
        }
        if($this->updated_at) {
            $data['updatedAt'] = $this->updated_at;
        }

        // Return final data to be attached to the API resource:
        return $data;
    }
}
