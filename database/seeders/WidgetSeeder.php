<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Widget\Models\Widget as WidgetModel;
use Theme;

class WidgetSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('widgets');

        WidgetModel::truncate();

        $data = [
            'en_US' => [
                [
                    'widget_id' => 'NewsletterWidget',
                    'sidebar_id' => 'pre_footer_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'NewsletterWidget',
                        'title' => 'New Things Will Always <br> Update Regularly',
                        'background_image' => 'general/newsletter-background-image.png',
                        'image_left' => 'general/newsletter-image-left.png',
                        'image_right' => 'general/newsletter-image-right.png',
                    ],
                ],
                [
                    'widget_id' => 'SiteInformationWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 1,
                    'data' => [
                        'introduction' => 'JobBox is the heart of the design community and the best resource to discover and connect with designers and jobs worldwide.',
                        'facebook_url' => '#',
                        'twitter_url' => '#',
                        'linkedin_url' => '#',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Resources',
                        'menu_id' => 'resources',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Community',
                        'menu_id' => 'community',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Quick links',
                        'menu_id' => 'quick-links',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 5,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'More',
                        'menu_id' => 'more',
                    ],
                ],
                [
                    'widget_id' => 'DownloadWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 6,
                    'data' => [
                        'app_store_url' => '#',
                        'app_store_image' => 'general/app-store.png',
                        'android_app_url' => '#',
                        'google_play_image' => 'general/android.png',
                    ],
                ],
                [
                    'widget_id' => 'BlogSearchWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'BlogSearchWidget',
                        'name' => 'Search',
                    ],
                ],
                [
                    'widget_id' => 'BlogCategoriesWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'BlogCategoriesWidget',
                        'name' => 'Categories',
                    ],
                ],
                [
                    'widget_id' => 'BlogPostsWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'BlogPostsWidget',
                        'type' => 'popular',
                        'name' => 'Popular Posts',
                    ],
                ],
                [
                    'widget_id' => 'BlogTagsWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'BlogTagsWidget',
                        'name' => 'Popular Tags',
                    ],
                ],
                [
                    'widget_id' => 'BlogSearchWidget',
                    'sidebar_id' => 'blog_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'BlogSearchWidget',
                        'name' => 'Blog Search',
                        'description' => 'Search blog posts',
                    ],
                ],
                [
                    'widget_id' => 'BlogPostsWidget',
                    'sidebar_id' => 'blog_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'BlogPostsWidget',
                        'name' => 'Blog posts',
                        'description' => 'Blog posts widget.',
                        'type' => 'popular',
                        'number_display' => 5,
                    ],
                ],
                [
                    'widget_id' => 'AdsBannerWidget',
                    'sidebar_id' => 'blog_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'AdsBannerWidget',
                        'name' => 'Ads banner',
                        'banner_ads' => 'widgets/widget-banner.png',
                        'url' => '/',
                    ],
                ],
                [
                    'widget_id' => 'GalleryWidget',
                    'sidebar_id' => 'blog_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'GalleryWidget',
                        'name' => 'Gallery',
                        'title_gallery' => 'Gallery',
                        'number_image' => 8,
                    ],
                ],
                [
                    'widget_id' => 'AdsBannerWidget',
                    'sidebar_id' => 'candidate_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'AdsBannerWidget',
                        'name' => 'Ads banner',
                        'banner_ads' => 'widgets/widget-banner.png',
                        'url' => '/',
                    ],
                ],
                [
                    'widget_id' => 'AdsBannerWidget',
                    'sidebar_id' => 'company_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'AdsBannerWidget',
                        'name' => 'Ads banner',
                        'banner_ads' => 'widgets/widget-banner.png',
                        'url' => '/',
                    ],
                ],
            ],
            'vi' => [
                [
                    'widget_id' => 'NewsletterWidget',
                    'sidebar_id' => 'pre_footer_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'NewsletterWidget',
                        'title' => 'Mọi tin tức đều được <br> cập nhật thường xuyên',
                        'background_image' => 'general/newsletter-background-image.png',
                        'image_left' => 'general/newsletter-image-left.png',
                        'image_right' => 'general/newsletter-image-right.png',
                    ],
                ],
                [
                    'widget_id' => 'SiteInformationWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 1,
                    'data' => [
                        'introduction' => 'JobBox là trung tâm của cộng đồng thiết kế và là nguồn tài nguyên tốt nhất để khám phá và kết nối với các nhà thiết kế và công việc trên toàn thế giới.',
                        'facebook_url' => '#',
                        'twitter_url' => '#',
                        'linkedin_url' => '#',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Tài nguyên',
                        'menu_id' => 'resources',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Cộng đồng',
                        'menu_id' => 'community',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Liên kết nhanh',
                        'menu_id' => 'quick-links',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 5,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Còn thêm',
                        'menu_id' => 'more',
                    ],
                ],
                [
                    'widget_id' => 'DownloadWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 6,
                    'data' => [
                        'app_store_url' => '#',
                        'app_store_image' => 'general/app-store.png',
                        'android_app_url' => '#',
                        'google_play_image' => 'general/android.png',
                    ],
                ],
                [
                    'widget_id' => 'BlogSearchWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'BlogSearchWidget',
                        'name' => 'Tìm kiếm',
                    ],
                ],
                [
                    'widget_id' => 'BlogCategoriesWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'BlogCategoriesWidget',
                        'name' => 'Danh mục',
                    ],
                ],
                [
                    'widget_id' => 'BlogPostsWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'BlogPostsWidget',
                        'type' => 'popular',
                        'name' => 'Bài viết phổ biến',
                    ],
                ],
                [
                    'widget_id' => 'BlogTagsWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'BlogTagsWidget',
                        'name' => 'Thẻ phổ biến]',
                    ],
                ],
                [
                    'widget_id' => 'BlogSearchWidget',
                    'sidebar_id' => 'blog_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'BlogSearchWidget',
                        'name' => 'Tìm kiếm bài viết',
                        'description' => 'Tìm kiếm bài viết blog',
                    ],
                ],
                [
                    'widget_id' => 'BlogPostsWidget',
                    'sidebar_id' => 'blog_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'BlogPostsWidget',
                        'name' => 'Bài viết Blog',
                        'description' => 'Widget bài viết Blog.',
                        'type' => 'popular',
                        'number_display' => 5,
                    ],
                ],
                [
                    'widget_id' => 'AdsBannerWidget',
                    'sidebar_id' => 'blog_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'AdsBannerWidget',
                        'name' => 'Biểu ngữ Ads',
                        'banner_ads' => 'widgets/widget-banner.png',
                        'url' => '/',
                    ],
                ],
                [
                    'widget_id' => 'GalleryWidget',
                    'sidebar_id' => 'blog_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'GalleryWidget',
                        'name' => 'Thư viện ảnh',
                        'title_gallery' => 'Thư viện ảnh',
                        'number_image' => 8,
                    ],
                ],
                [
                    'widget_id' => 'AdsBannerWidget',
                    'sidebar_id' => 'candidate_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'AdsBannerWidget',
                        'name' => 'Biểu ngữ Ads',
                        'banner_ads' => 'widgets/widget-banner.png',
                        'url' => '/',
                    ],
                ],
                [
                    'widget_id' => 'AdsBannerWidget',
                    'sidebar_id' => 'company_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'AdsBannerWidget',
                        'name' => 'Biểu ngữ Ads',
                        'banner_ads' => 'widgets/widget-banner.png',
                        'url' => '/',
                    ],
                ],
            ],
        ];

        $theme = Theme::getThemeName();

        foreach ($data as $locale => $widgets) {
            foreach ($widgets as $item) {
                $item['theme'] = $locale == 'en_US' ? $theme : ($theme . '-' . $locale);
                WidgetModel::create($item);
            }
        }
    }
}
