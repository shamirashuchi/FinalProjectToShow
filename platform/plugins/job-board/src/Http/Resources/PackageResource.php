<?php

namespace Botble\JobBoard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'price_text' => $this->price_text,
            'price_per_job_text' => $this->price_per_job_text,
            'percent_save' => $this->percent_save,
            'number_of_listings' => $this->number_of_listings,
            'number_jobs_free' => $this->number_jobs_free,
            'price_text_with_sale_off' => $this->price_text_with_sale_off,
        ];
    }
}
