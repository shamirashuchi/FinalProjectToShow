<?php

namespace Theme\Jobbox\Http\Resources;

use BaseHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use RvMedia;

class TestimonialResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => BaseHelper::clean($this->content),
            'company' => $this->company,
            'image' => RvMedia::getImageUrl($this->image, null, false, RvMedia::getDefaultImage()),
        ];
    }
}
