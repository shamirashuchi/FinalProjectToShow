<?php

namespace Database\Seeders;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Location\Models\City;
use Botble\Location\Models\Country;
use Botble\Location\Models\State;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Facades\DB;
use MetaBox;

class LocationSeeder extends BaseSeeder
{
    public function run(): void
    {
        City::truncate();
        DB::table('cities_translations')->truncate();
        State::truncate();
        DB::table('states_translations')->truncate();
        Country::truncate();
        DB::table('countries_translations')->truncate();

        $this->uploadFiles('locations');

        Slug::whereIn('reference_type', [City::class, State::class, Country::class])->delete();
        MetaBoxModel::whereIn('reference_type', [City::class, State::class, Country::class])->delete();
        LanguageMeta::whereIn('reference_type', [City::class, State::class, Country::class])->delete();
        $now = now();

        $countries = [
            [
                'id' => 1,
                'name' => 'France',
                'nationality' => 'French',
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'code' => 'FRA',
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'England',
                'nationality' => 'English',
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'code' => 'UK',
                'created_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'USA',
                'nationality' => 'Americans',
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'code' => 'US',
                'created_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Holland',
                'nationality' => 'Dutch',
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'code' => 'HL',
                'created_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Denmark',
                'nationality' => 'Danish',
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'code' => 'DN',
                'created_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Germany',
                'nationality' => 'Danish',
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'code' => 'DN',
                'created_at' => $now,
            ],
        ];

        $states = [
            [
                'id' => 1,
                'name' => 'France',
                'abbreviation' => 'FR',
                'country_id' => 1,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'England',
                'abbreviation' => 'EN',
                'country_id' => 2,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'New York',
                'abbreviation' => 'NY',
                'country_id' => 1,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Holland',
                'abbreviation' => 'HL',
                'country_id' => 4,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Denmark',
                'abbreviation' => 'DN',
                'country_id' => 5,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Germany',
                'abbreviation' => 'GER',
                'country_id' => 1,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $cities = [
            [
                'id' => 1,
                'name' => 'Paris',
                'state_id' => 1,
                'country_id' => 1,
                'record_id' => null,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'London',
                'state_id' => 2,
                'country_id' => 2,
                'record_id' => null,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'New York',
                'state_id' => 3,
                'country_id' => 3,
                'record_id' => null,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'New York',
                'state_id' => 4,
                'country_id' => 4,
                'record_id' => null,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Copenhagen',
                'state_id' => 5,
                'country_id' => 5,
                'record_id' => null,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Berlin',
                'state_id' => 6,
                'country_id' => 6,
                'record_id' => null,
                'order' => 0,
                'is_default' => 0,
                'status' => BaseStatusEnum::PUBLISHED,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert($country);
        }

        foreach ($states as $state) {
            DB::table('states')->insert($state);
        }

        foreach ($cities as $city) {
            $result = City::create($city);
            MetaBox::saveMetaBoxData($result, 'city_image', 'locations/location' . $city['id'] . '.png');
        }
    }
}
