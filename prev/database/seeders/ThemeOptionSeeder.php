<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Setting\Models\Setting;
use Theme;

class ThemeOptionSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('general');
        $this->uploadFiles('authentication');

        $theme = Theme::getThemeName();

        Setting::where('key', 'LIKE', 'theme-' . $theme . '-%')
            ->orWhereIn('key', [
                'show_admin_bar',
                'theme',
                'admin_logo',
                'admin_favicon',
            ])
            ->delete();

        Setting::insertOrIgnore([
            [
                'key' => 'show_admin_bar',
                'value' => '1',
            ],
            [
                'key' => 'theme',
                'value' => $theme,
            ],
            [
                'key' => 'admin_logo',
                'value' => 'general/logo-light.png',
            ],
            [
                'key' => 'admin_favicon',
                'value' => 'general/favicon.png',
            ],
        ]);

        $data = [
            'en_US' => [
                [
                    'key' => 'site_title',
                    'value' => 'JobBox - Laravel Job Board Script',
                ],
                [
                    'key' => 'seo_description',
                    'value' => 'JobBox is a neat, clean and professional job board website script for your organization. It’s easy to build a complete Job Board site with JobBox script.',
                ],
                [
                    'key' => 'copyright',
                    'value' => '©' . now()->format('Y') . ' Archi Elite JSC Technologies. All right reserved.',
                ],
                [
                    'key' => 'favicon',
                    'value' => 'general/favicon.png',
                ],
                [
                    'key' => 'logo',
                    'value' => 'general/logo.png',
                ],
                [
                    'key' => 'hotline',
                    'value' => '+(123) 345-6789',
                ],
                [
                    'key' => 'cookie_consent_message',
                    'value' => 'Your experience on this site will be improved by allowing cookies ',
                ],
                [
                    'key' => 'cookie_consent_learn_more_url',
                    'value' => '/cookie-policy',
                ],
                [
                    'key' => 'cookie_consent_learn_more_text',
                    'value' => 'Cookie Policy',
                ],
                [
                    'key' => 'homepage_id',
                    'value' => 1,
                ],
                [
                    'key' => 'blog_page_id',
                    'value' => 13,
                ],
                [
                    'key' => 'preloader_enabled',
                    'value' => 'no',
                ],
                [
                    'key' => 'job_categories_page_id',
                    'value' => 19,
                ],
                [
                    'key' => 'job_candidates_page_id',
                    'value' => 9,
                ],
                [
                    'key' => 'default_company_cover_image',
                    'value' => 'general/cover-image.png',
                ],
                [
                    'key' => 'job_companies_page_id',
                    'value' => 8,
                ],
                [
                    'key' => 'job_list_page_id',
                    'value' => 7,
                ],
                [
                    'key' => 'email',
                    'value' => 'contact@jobbox.com',
                ],
                [
                    'key' => '404_page_image',
                    'value' => 'general/404.png',
                ],
                [
                    'key' => 'background_breadcrumb',
                    'value' => 'pages/bg-breadcrumb.png',
                ],
                [
                    'key' => 'blog_page_template_blog',
                    'value' => 'blog_gird_1',
                ],
                [
                    'key' => 'background_blog_single',
                    'value' => 'pages/img-single.png',
                ],
                [
                    'key' => 'auth_background_image_1',
                    'value' => 'authentication/img-1.png',
                ],
                [
                    'key' => 'auth_background_image_2',
                    'value' => 'authentication/img-2.png',
                ],
            ],

            'vi' => [],
        ];

        foreach ($data as $locale => $options) {
            foreach ($options as $item) {
                $item['key'] = 'theme-' . $theme . '-' . ($locale != 'en_US' ? $locale . '-' : '') . $item['key'];

                Setting::insertOrIgnore($item);
            }
        }

        $socialLinks = [
            [
                [
                    'key' => 'social-name',
                    'value' => 'Whatsapp',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'uil uil-whatsapp',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://whatsapp.com',
                ],
            ],
            [
                [
                    'key' => 'social-name',
                    'value' => 'Facebook messenger',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'uil uil-facebook-messenger-alt',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://messenger.com',
                ],
            ],
            [
                [
                    'key' => 'social-name',
                    'value' => 'Instagram',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'uil uil-instagram',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://instagram.com',
                ],
            ],
            [
                [
                    'key' => 'social-name',
                    'value' => 'Email',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'uil uil-envelope',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'mailto:support@archielite.com',
                ],
            ],
            [
                [
                    'key' => 'social-name',
                    'value' => 'Twitter',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'uil uil-twitter-alt',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://twitter.com',
                ],
            ],
        ];

        Setting::insertOrIgnore([
            'key' => 'theme-' . $theme . '-social_links',
            'value' => json_encode($socialLinks),
        ]);

        Setting::insertOrIgnore([
            'key' => 'theme-' . $theme . '-vi-social_links',
            'value' => json_encode($socialLinks),
        ]);
    }
}
