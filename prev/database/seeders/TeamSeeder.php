<?php

namespace Database\Seeders;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Supports\BaseSeeder;
use Botble\Team\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('teams');

        $teams = [
            [
                'name' => 'Jack Persion',
                'title' => 'Developer Fullstack',
                'location' => 'USA',
            ],
            [
                'name' => 'Tyler Men',
                'title' => 'Business Analyst',
                'location' => 'Qatar',
            ],
            [
                'name' => 'Mohamed Salah',
                'title' => 'Developer Fullstack',
                'location' => 'India',
            ],
            [
                'name' => 'Xao Shin',
                'title' => 'Developer Fullstack',
                'location' => 'China',
            ],
            [
                'name' => 'Peter Cop',
                'title' => 'Designer',
                'location' => 'Russia',
            ],
            [
                'name' => 'Jacob Jones',
                'title' => 'Frontend Developer',
                'location' => 'New York, US',
            ],
            [
                'name' => 'Court Henry',
                'title' => 'Backend Developer',
                'location' => 'Portugal',
            ],
            [
                'name' => 'Theresa',
                'title' => 'Backend Developer',
                'location' => 'Thailand',
            ],

        ];

        Team::truncate();
        DB::table('teams_translations')->truncate();

        foreach ($teams as $index => $item) {
            $item['photo'] = 'teams/' . ($index + 1) . '.png';
            $item['socials'] = json_encode([
                'facebook' => 'fb.com',
                'twitter' => 'twitter.com',
                'instagram' => 'instagram.com',
            ]);

            $item['status'] = BaseStatusEnum::PUBLISHED;

            Team::create($item);
        }

        $translations = [
            [
                'name' => 'Jack Persion',
                'title' => 'Developer Fullstack',
                'location' => 'Mỹ',
            ],
            [
                'name' => 'Tyler Men',
                'title' => 'Business Analyst',
                'location' => 'Qatar',
            ],
            [
                'name' => 'Mohamed Salah',
                'title' => 'Developer Fullstack',
                'location' => 'Ấn độ',
            ],
            [
                'name' => 'Xao Shin',
                'title' => 'Developer Fullstack',
                'location' => 'Trung Quốc',
            ],
            [
                'name' => 'Peter Cop',
                'title' => 'Designer',
                'location' => 'Nga',
            ],
            [
                'name' => 'Jacob Jones',
                'title' => 'Frontend Developer',
                'location' => 'Mỹ',
            ],
            [
                'name' => 'Court Henry',
                'title' => 'Backend Developer',
                'location' => 'Bồ Đào Nha',
            ],
            [
                'name' => 'Theresa',
                'title' => 'Backend Developer',
                'location' => 'Thái Lan',
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['teams_id'] = $index + 1;

            DB::table('teams_translations')->insert($item);
        }
    }
}
