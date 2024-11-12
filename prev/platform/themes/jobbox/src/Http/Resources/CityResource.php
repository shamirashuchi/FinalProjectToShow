<?php

namespace Theme\Jobbox\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'state_name' => $this->state->name,
            'label' => $this->name . ', ' . $this->state->name,
        ];
    }
}
