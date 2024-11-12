<?php

namespace Theme\Jobbox\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->whenLoaded('slugable'),
            'description' => $this->description,
        ];
    }
}
