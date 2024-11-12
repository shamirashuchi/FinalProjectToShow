<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Enums\AccountTypeEnum;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\AccountEducation;
use Botble\JobBoard\Models\AccountExperience;
use Botble\Media\Models\MediaFile;
use Botble\Slug\Models\Slug;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use MetaBox;
use SlugHelper;

class AccountSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('resume');

        $files = $this->uploadFiles('accounts');

        $faker = Factory::create();

        Account::truncate();
        AccountExperience::truncate();
        AccountEducation::truncate();
        Slug::where('reference_type', Account::class)->delete();
        MetaBoxModel::where('reference_type', Account::class)->delete();

        $companies = [
            'Spa Paragon',
            'GameDay Cateringn',
            'Exploration Kids',
            'Darwin Travel',
            'Party Plex',
        ];

        $specializeds = [
            'Anthropology',
            'Art History',
            'Classical Studies',
            'Economics',
            'Culture and Technology Studie',
        ];

        $jobs = [
            'Marketing Coordinator',
            'Web Designer',
            'Dog Trainer',
            'President of Sales',
            'Project Manager',
        ];

        $universities = [
            'Adams State College',
            'The University of the State of Alabama',
            'Associated Mennonite Biblical Seminary',
            'Antioch University McGregor',
            'American Institute of Health Technology',
            'Gateway Technical College',
        ];

        $description = 'There are many variations of passages of available, but the majority alteration in some form.
                As a highly skilled and successfull product development and design specialist with more than 4 Years of
                My experience';

        $accounts = [
            [
                'email' => 'employer@archielite.com',
                'type' => AccountTypeEnum::EMPLOYER,
                'description' => 'Software Developer',
            ],
            [
                'email' => 'job_seeker@archielite.com',
                'type' => AccountTypeEnum::JOB_SEEKER,
                'description' => 'Creative Designer',
                'is_public_profile' => true,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Harding',
                'email' => 'sarah_harding@archielite.com',
                'type' => AccountTypeEnum::EMPLOYER,
                'avatar' => 'accounts/user1.png',
                'description' => 'Creative Designer',
            ],
            [
                'first_name' => 'Steven',
                'last_name' => 'Jobs',
                'email' => 'steven_jobs@archielite.com',
                'type' => AccountTypeEnum::EMPLOYER,
                'avatar' => 'accounts/user2.png',
                'description' => 'Creative Designer',
            ],
            [
                'first_name' => 'Wiliam',
                'last_name' => 'Kend',
                'email' => 'wiliam_kend@archielite.com',
                'type' => AccountTypeEnum::EMPLOYER,
                'avatar' => 'accounts/user3.png',
                'description' => 'Creative Designer',
            ],
        ];

        for ($i = 0; $i < 100; $i++) {
            $accountType = isset($accounts[$i]) ? $accounts[$i]['type'] : array_rand(AccountTypeEnum::labels());

            $account = Account::create([
                'first_name' => $accounts[$i]['first_name'] ?? $faker->firstName(),
                'last_name' => $accounts[$i]['last_name'] ?? $faker->lastName(),
                'email' => isset($accounts[$i]) ? $accounts[$i]['email'] : $faker->email(),
                'password' => Hash::make('12345678'),
                'dob' => $faker->dateTime(),
                'phone' => $faker->e164PhoneNumber(),
                'description' => isset($accounts[$i]) ? $accounts[$i]['description'] : $faker->realText(20),
                'avatar_id' => isset($accounts[$i]['avatar'])
                    ? MediaFile::where('url', $accounts[$i]['avatar'])->first()->id
                    : $files[rand(0, 4)]['data']->id,
                'confirmed_at' => now(),
                'type' => $accountType,
                'resume' => $accountType === AccountTypeEnum::JOB_SEEKER ? 'resume/01.pdf' : null,
                'is_public_profile' => rand(0, 1),
                'bio' => $faker->realText(),
                'address' => $faker->address(),
                'is_featured' => rand(0, 1),
                'available_for_hiring' => rand(0, 1),
                'views' => rand(100, 5000),
            ]);

            if ($account->isJobSeeker()) {
                AccountEducation::create([
                    'school' => $universities[rand(0, count($universities)-1)],
                    'specialized' => $specializeds[rand(0, count($specializeds)-1)],
                    'account_id' => $account->id,
                    'description' => $description,
                    'started_at' => Carbon::now()->toDateString(),
                    'ended_at' => Carbon::now()->toDateString(),
                ]);

                AccountExperience::create([
                    'company' => $companies[rand(0, count($companies)-1)],
                    'position' => $jobs[rand(0, count($jobs)-1)],
                    'account_id' => $account->id,
                    'description' => $description,
                    'started_at' => Carbon::now()->toDateString(),
                    'ended_at' => Carbon::now()->toDateString(),
                ]);
            }

            MetaBox::saveMetaBoxData($account, 'cover_image', 'accounts/cover' . (rand(1, 3)) . '.png');

            Slug::create([
                'reference_type' => Account::class,
                'reference_id' => $account->id,
                'key' => Str::slug($account->name),
                'prefix' => SlugHelper::getPrefix(Account::class),
            ]);
        }
    }
}
