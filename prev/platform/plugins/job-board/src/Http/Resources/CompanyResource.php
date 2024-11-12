<?php

namespace Botble\JobBoard\Http\Resources;

use Botble\Location\Http\Resources\CityResource;
use Botble\Location\Http\Resources\CountryResource;
use Botble\Location\Http\Resources\StateResource;
use Illuminate\Http\Resources\Json\JsonResource;
use RvMedia;

class CompanyResource extends JsonResource
{
    protected bool $location = false;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->location = is_plugin_active('location');
    }

    public function toArray($request): array
    {
        return array_merge(
            [
                'id' => $this->id,
                'name' => $this->name,
                'address' => $this->address,
                'accounts' => AccountResource::collection($this->accounts),
                'logo' => RvMedia::getImageUrl($this->logo),
                'logo_thumb' => $this->logo_thumb,
                'url' => $this->url,
            ],
            $this->location ? [
                'country' => new CountryResource($this->country),
                'state' => new StateResource($this->state),
                'city' => new CityResource($this->city),
            ] : []
        );
    }
}
