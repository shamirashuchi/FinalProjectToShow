<?php

namespace Botble\JobBoard\Http\Resources;

use Botble\Location\Http\Resources\CityResource;
use Botble\Location\Http\Resources\StateResource;
use Illuminate\Http\Resources\Json\JsonResource;
use RvMedia;

class JobResource extends JsonResource
{
    protected bool $location = false;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->location = is_plugin_active('location');
    }

    public function toArray($request): array
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'image' => $this->company->logo ? RvMedia::getImageUrl(
                $this->company->logo,
                'small',
                false,
                RvMedia::getDefaultImage()
            ) : null,
            'company' => new CompanyResource($this->company),
            'date' => $this->created_at->translatedFormat('M d, Y'),
        ], $this->location ? [
            'city' => new CityResource($this->city),
            'state' => new StateResource($this->state),
        ] : []);
    }
}
