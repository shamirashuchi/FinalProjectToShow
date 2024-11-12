<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\Package;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends BaseSeeder
{
    public function run(): void
    {
        Package::truncate();
        DB::table('jb_packages_translations')->truncate();

        $data = [
            [
                'name' => 'Free First Post',
                'price' => 0,
                'currency_id' => 1,
                'percent_save' => 0,
                'order' => 0,
                'number_of_listings' => 1,
                'account_limit' => 1,
                'is_default' => false,
            ],
            [
                'name' => 'Single Post',
                'price' => 250,
                'currency_id' => 1,
                'percent_save' => 0,
                'order' => 0,
                'number_of_listings' => 1,
                'is_default' => true,
            ],
            [
                'name' => '5 Posts',
                'price' => 1000,
                'currency_id' => 1,
                'percent_save' => 20,
                'order' => 0,
                'number_of_listings' => 5,
                'is_default' => false,
            ],
        ];

        $translations = [
            'vi' => [
                [
                    'name' => 'Miễn phí đăng bài đầu tiên',
                ],
                [
                    'name' => 'Bài đăng đơn',
                ],
                [
                    'name' => '5 bài đăng',
                ],
            ],
        ];

        foreach ($data as $index => $item) {
            Package::create($item);
            DB::table('jb_packages_translations')->insert([
                'lang_code' => 'vi',
                'jb_packages_id' => $index + 1,
                'name' => Arr::get($translations, 'vi.' . $index . '.name'),
            ]);
        }
    }
}
