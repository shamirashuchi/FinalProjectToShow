<?php

namespace Database\Seeders;

use Botble\ACL\Models\User;
use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\Tag;
use Botble\JobBoard\Models\Account;
use Botble\Language\Models\LanguageMeta;
use Botble\Slug\Models\Slug;
use Faker\Factory;
use Html;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MetaBox;
use RvMedia;
use SlugHelper;

class BlogSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('news');

        Post::truncate();
        Category::truncate();
        Tag::truncate();
        DB::table('posts_translations')->truncate();
        DB::table('categories_translations')->truncate();
        DB::table('tags_translations')->truncate();
        Slug::where('reference_type', Post::class)->delete();
        Slug::where('reference_type', Tag::class)->delete();
        Slug::where('reference_type', Category::class)->delete();
        MetaBoxModel::where('reference_type', Post::class)->delete();
        MetaBoxModel::where('reference_type', Tag::class)->delete();
        MetaBoxModel::where('reference_type', Category::class)->delete();
        LanguageMeta::where('reference_type', Post::class)->delete();
        LanguageMeta::where('reference_type', Tag::class)->delete();
        LanguageMeta::where('reference_type', Category::class)->delete();

        $faker = Factory::create();

        $categories = [
            [
                'name' => 'Design',
                'is_default' => true,
            ],
            [
                'name' => 'Lifestyle',
            ],
            [
                'name' => 'Travel Tips',
                'parent_id' => 2,
            ],
            [
                'name' => 'Healthy',
            ],
            [
                'name' => 'Travel Tips',
                'parent_id' => 4,
            ],
            [
                'name' => 'Hotel',
            ],
            [
                'name' => 'Nature',
                'parent_id' => 6,
            ],
        ];

        foreach ($categories as $index => $item) {
            $item['description'] = $faker->text();
            $item['author_id'] = User::value('id');
            $item['author_type'] = User::class;
            $item['is_featured'] = ! isset($item['parent_id']) && $index != 0;

            $category = Category::create($item);

            Slug::create([
                'reference_type' => Category::class,
                'reference_id' => $category->id,
                'key' => Str::slug($category->name),
                'prefix' => SlugHelper::getPrefix(Category::class),
            ]);
        }

        $tags = [
            [
                'name' => 'New',
            ],
            [
                'name' => 'Event',
            ],
        ];

        foreach ($tags as $item) {
            $item['author_id'] = User::value('id');
            $item['author_type'] = User::class;
            $tag = Tag::create($item);

            Slug::create([
                'reference_type' => Tag::class,
                'reference_id' => $tag->id,
                'key' => Str::slug($tag->name),
                'prefix' => SlugHelper::getPrefix(Tag::class),
            ]);
        }

        $posts = [
            [
                'name' => 'Interview Question: Why Dont You Have a Degree?',
            ],
            [
                'name' => '21 Job Interview Tips: How To Make a Great Impression',
            ],
            [
                'name' => '39 Strengths and Weaknesses To Discuss in a Job Interview',
            ],
        ];

        $authorData = [3, 4, 5];

        foreach ($posts as $index => $item) {
            $item['content'] =
                ($index % 3 == 0 ? Html::tag(
                    'p',
                    '[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]'
                ) : '') .
                Html::tag('p', $faker->realText(1000)) .
                Html::tag(
                    'p',
                    Html::image(
                        RvMedia::getImageUrl('news/' . $faker->numberBetween(1, 5) . '.jpg', 'medium'),
                        'image',
                        ['style' => 'width: 100%', 'class' => 'image_resized']
                    )
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(500)) .
                Html::tag(
                    'p',
                    Html::image(
                        RvMedia::getImageUrl('news/' . $faker->numberBetween(6, 10) . '.jpg', 'medium'),
                        'image',
                        ['style' => 'width: 100%', 'class' => 'image_resized']
                    )
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(1000)) .
                Html::tag(
                    'p',
                    Html::image(
                        RvMedia::getImageUrl('news/' . $faker->numberBetween(11, 14) . '.jpg', 'medium'),
                        'image',
                        ['style' => 'width: 100%', 'class' => 'image_resized']
                    )
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(1000));
            $item['author_id'] = $authorData[$index];
            $item['author_type'] = Account::class;
            $item['views'] = $faker->numberBetween(100, 2500);
            $item['is_featured'] = $index < 6;
            $item['image'] = 'news/img-news' . ($index + 1) . '.png';
            $item['description'] = $faker->text(250);
            $item['created_at'] = $faker->dateTimeBetween('-1 month');
            $item['updated_at'] = $item['created_at'];

            $item['content'] = str_replace(url(''), '', $item['content']);

            $post = Post::create($item);

            if ($index < 3) {
                MetaBox::saveMetaBoxData($post, 'cover_image', 'news/cover-image' . ($index + 1) . '.png');
            }

            $post->categories()->sync([
                $faker->numberBetween(1, 4),
                $faker->numberBetween(5, 7),
            ]);

            $post->tags()->sync([1, 2, 3, 4, 5]);

            Slug::create([
                'reference_type' => Post::class,
                'reference_id' => $post->id,
                'key' => Str::slug($post->name),
                'prefix' => SlugHelper::getPrefix(Post::class),
            ]);
        }

        $translations = [
            [
                'name' => 'Phong cách sống',
            ],
            [
                'name' => 'Sức khỏe',
            ],
            [
                'name' => 'Món ngon',
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['categories_id'] = Category::skip($index)->value('id');

            DB::table('categories_translations')->insert($item);
        }

        $translations = [
            [
                'name' => 'Tin tức',
            ],
            [
                'name' => 'Sự kiện',
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['tags_id'] = Tag::skip($index)->value('id');

            DB::table('tags_translations')->insert($item);
        }

        $translations = [
            [
                'name' => 'Xu hướng túi xách hàng đầu năm 2020 cần biết',
            ],
            [
                'name' => 'Các Chiến lược Tối ưu hóa Công cụ Tìm kiếm Hàng đầu!',
            ],
            [
                'name' => 'Bạn sẽ chọn công ty nào?',
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';

            $post = Post::skip($index)->first();

            $item['posts_id'] = $post->id;
            $item['description'] = $post->description;
            $item['content'] = $post->content;

            DB::table('posts_translations')->insert($item);
        }
    }
}
