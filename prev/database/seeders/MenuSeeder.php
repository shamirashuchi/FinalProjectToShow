<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Post;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\Category;
use Botble\JobBoard\Models\Company;
use Botble\JobBoard\Models\Job;
use Botble\Language\Models\LanguageMeta;
use Botble\Menu\Models\Menu as MenuModel;
use Botble\Menu\Models\MenuLocation;
use Botble\Menu\Models\MenuNode;
use Botble\Page\Models\Page;
use Illuminate\Support\Arr;
use Menu;

class MenuSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = [
            'en_US' => [
                [
                    'name' => 'Main menu',
                    'slug' => 'main-menu',
                    'location' => 'main-menu',
                    'items' => [
                        [
                            'title' => 'Home',
                            'url' => '/',
                            'children' => [
                                [
                                    'title' => 'Home 1',
                                    'reference_id' => 1,
                                    'reference_type' => Page::class,
                                    'position' => 1,
                                ],
                                [
                                    'title' => 'Home 2',
                                    'reference_id' => 2,
                                    'reference_type' => Page::class,
                                    'position' => 2,
                                ],
                                [
                                    'title' => 'Home 3',
                                    'reference_id' => 3,
                                    'reference_type' => Page::class,
                                    'position' => 3,
                                ],
                                [
                                    'title' => 'Home 4',
                                    'reference_id' => 4,
                                    'reference_type' => Page::class,
                                    'position' => 4,
                                ],
                                [
                                    'title' => 'Home 5',
                                    'reference_id' => 5,
                                    'reference_type' => Page::class,
                                    'position' => 5,
                                ],
                                [
                                    'title' => 'Home 6',
                                    'reference_id' => 6,
                                    'reference_type' => Page::class,
                                    'position' => 6,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Find a Job',
                            'reference_id' => 7,
                            'reference_type' => Page::class,
                            'children' => [
                                [
                                    'title' => 'Jobs Grid',
                                    'url' => '/jobs?layout=grid',
                                ],
                                [
                                    'title' => 'Jobs List',
                                    'url' => '/jobs',
                                ],
                                [
                                    'title' => 'Job Details',
                                    'url' => Job::find(1)->url,
                                ],
                                [
                                    'title' => 'Job External',
                                    'url' => Job::find(2)->url,
                                ],
                                [
                                    'title' => 'Job Hide Company',
                                    'url' => Job::find(3)->url,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Companies',
                            'reference_id' => 8,
                            'reference_type' => Page::class,
                            'children' => [
                                [
                                    'title' => 'Companies',
                                    'reference_id' => 8,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Company Details',
                                    'url' => Company::find(1)->url,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Candidates',
                            'reference_id' => 9,
                            'reference_type' => Page::class,
                            'children' => [
                                [
                                    'title' => 'Candidates Grid',
                                    'reference_id' => 9,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Candidate Details',
                                    'url' => Account::find(2)->url,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Pages',
                            'url' => '#',
                            'children' => [
                                [
                                    'title' => 'About Us',
                                    'reference_id' => 10,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Pricing Plan',
                                    'reference_id' => 11,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Contact Us',
                                    'reference_id' => 12,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Register',
                                    'url' => route('public.account.register'),
                                ],
                                [
                                    'title' => 'Sign in',
                                    'url' => route('public.account.login'),
                                ],
                                [
                                    'title' => 'Reset Password',
                                    'url' => route('public.account.password.request'),
                                ],
                            ],
                        ],
                        [
                            'title' => 'Blog',
                            'reference_id' => 13,
                            'reference_type' => Page::class,
                            'children' => [
                                [
                                    'title' => 'Blog Grid',
                                    'reference_id' => 13,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Blog Single',
                                    'url' => Post::find(1)->url,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Resources',
                    'slug' => 'resources',
                    'items' => [
                        [
                            'title' => 'About Us',
                            'reference_id' => 10,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Our Team',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Products',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Contact',
                            'reference_id' => 12,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
                [
                    'name' => 'Community',
                    'slug' => 'community',
                    'items' => [
                        [
                            'title' => 'Feature',
                            'reference_id' => 10,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Pricing',
                            'reference_id' => 11,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Credit',
                            'url' => '#',
                        ],
                        [
                            'title' => 'FAQ',
                            'reference_id' => 15,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
                [
                    'name' => 'Quick links',
                    'slug' => 'quick-links',
                    'items' => [
                        [
                            'title' => 'iOS',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Android',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Microsoft',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Desktop',
                            'url' => '#',
                        ],
                    ],
                ],
                [
                    'name' => 'More',
                    'slug' => 'more',
                    'items' => [
                        [
                            'title' => 'Cookie Policy',
                            'reference_id' => 14,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Terms',
                            'reference_id' => 18,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'FAQ',
                            'reference_id' => 5,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Coming Soon',
                            'reference_id' => 19,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
            ],
            'vi' => [
                [
                    'name' => 'Menu chính',
                    'slug' => 'menu-chinh',
                    'location' => 'main-menu',
                    'items' => [
                        [
                            'title' => 'Trang chủ',
                            'url' => '/',
                            'children' => [
                                [
                                    'title' => 'Trang chủ 1',
                                    'reference_id' => 1,
                                    'reference_type' => Page::class,
                                    'position' => 1,
                                ],
                                [
                                    'title' => 'Trang chủ 2',
                                    'reference_id' => 2,
                                    'reference_type' => Page::class,
                                    'position' => 2,
                                ],
                                [
                                    'title' => 'Trang chủ 3',
                                    'reference_id' => 3,
                                    'reference_type' => Page::class,
                                    'position' => 3,
                                ],
                                [
                                    'title' => 'Trang chủ 4',
                                    'reference_id' => 4,
                                    'reference_type' => Page::class,
                                    'position' => 4,
                                ],
                                [
                                    'title' => 'Trang chủ 5',
                                    'reference_id' => 5,
                                    'reference_type' => Page::class,
                                    'position' => 5,
                                ],
                                [
                                    'title' => 'Trang chủ 6',
                                    'reference_id' => 6,
                                    'reference_type' => Page::class,
                                    'position' => 6,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Tìm kiếm việc làm',
                            'reference_id' => 7,
                            'reference_type' => Page::class,
                            'children' => [
                                [
                                    'title' => 'Danh sách việc làm lưới',
                                    'url' => '/jobs?layout=grid',
                                ],
                                [
                                    'title' => 'Danh sách việc làm',
                                    'url' => '/jobs',
                                ],
                                [
                                    'title' => 'Chi tiết công việc',
                                    'url' => Job::find(1)->url,
                                ],
                                [
                                    'title' => 'Công việc bên ngoài',
                                    'url' => Job::find(2)->url,
                                ],
                                [
                                    'title' => 'Công việc công ty ẩn',
                                    'url' => Job::find(3)->url,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Công ty',
                            'reference_id' => 8,
                            'reference_type' => Page::class,
                            'children' => [
                                [
                                    'title' => 'Công ty',
                                    'reference_id' => 8,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Chi tiết Công ty',
                                    'url' => Company::find(1)->url,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Ứng viên',
                            'reference_id' => 9,
                            'reference_type' => Page::class,
                            'children' => [
                                [
                                    'title' => 'Danh sách Ứng viên',
                                    'reference_id' => 9,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Chi tiết ứng viên',
                                    'url' => Account::find(2)->url,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Trang',
                            'url' => '#',
                            'children' => [
                                [
                                    'title' => 'Giới thiệu',
                                    'reference_id' => 10,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Bảng giá',
                                    'reference_id' => 11,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Liên hệ',
                                    'reference_id' => 12,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Đăng ký',
                                    'url' => route('public.account.register'),
                                ],
                                [
                                    'title' => 'Đăng nhập',
                                    'url' => route('public.account.login'),
                                ],
                                [
                                    'title' => 'Khôi phục mật khẩu',
                                    'url' => route('public.account.password.request'),
                                ],
                            ],
                        ],
                        [
                            'title' => 'Blog',
                            'reference_id' => 13,
                            'reference_type' => Page::class,
                            'children' => [
                                [
                                    'title' => 'Danh sách bài viết',
                                    'reference_id' => 13,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Chi tiết bài viết',
                                    'url' => Post::find(1)->url,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Tài nguyên',
                    'slug' => 'tai-nguyen',
                    'items' => [
                        [
                            'title' => 'Giới thiệu',
                            'reference_id' => 10,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Đội ngũ',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Sản phẩm',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Liên hệ',
                            'reference_id' => 12,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
                [
                    'name' => 'Cộng đồng',
                    'slug' => 'cong-dong',
                    'items' => [
                        [
                            'title' => 'Tính năng',
                            'reference_id' => 10,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Bảng giá',
                            'reference_id' => 11,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Credit',
                            'url' => '#',
                        ],
                        [
                            'title' => 'FAQ',
                            'reference_id' => 15,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
                [
                    'name' => 'Liên kết nhanh',
                    'slug' => 'lien-key-nhanh',
                    'items' => [
                        [
                            'title' => 'iOS',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Android',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Microsoft',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Desktop',
                            'url' => '#',
                        ],
                    ],
                ],
                [
                    'name' => 'Còn thêm',
                    'slug' => 'con-them',
                    'items' => [
                        [
                            'title' => 'Chính sách cookie',
                            'reference_id' => 14,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Điều khoản',
                            'reference_id' => 18,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'FAQ',
                            'reference_id' => 5,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Sắp có',
                            'reference_id' => 19,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
            ],
        ];

        MenuModel::truncate();
        MenuLocation::truncate();
        MenuNode::truncate();
        LanguageMeta::where('reference_type', MenuModel::class)->delete();
        LanguageMeta::where('reference_type', MenuLocation::class)->delete();

        foreach ($data as $locale => $menus) {
            foreach ($menus as $index => $item) {
                $menu = MenuModel::create(Arr::except($item, ['items', 'location']));

                if (isset($item['location'])) {
                    $menuLocation = MenuLocation::create([
                        'menu_id' => $menu->id,
                        'location' => $item['location'],
                    ]);

                    $originValue = LanguageMeta::where([
                        'reference_id' => $locale == 'en_US' ? 1 : 2,
                        'reference_type' => MenuLocation::class,
                    ])->value('lang_meta_origin');

                    LanguageMeta::saveMetaData($menuLocation, $locale, $originValue);
                }

                foreach ($item['items'] as $menuNode) {
                    $this->createMenuNode($index, $menuNode, $locale, $menu->id);
                }

                $originValue = null;

                if ($locale !== 'en_US') {
                    $originValue = LanguageMeta::where([
                        'reference_id' => $index + 1,
                        'reference_type' => MenuModel::class,
                    ])->value('lang_meta_origin');
                }

                LanguageMeta::saveMetaData($menu, $locale, $originValue);
            }
        }

        Menu::clearCacheMenuItems();
    }

    protected function createMenuNode(int $index, array $menuNode, string $locale, int $menuId, int $parentId = 0): void
    {
        $menuNode['menu_id'] = $menuId;
        $menuNode['parent_id'] = $parentId;

        if (isset($menuNode['url'])) {
            $menuNode['url'] = str_replace(url(''), '', $menuNode['url']);
        }

        if (Arr::has($menuNode, 'children')) {
            $children = $menuNode['children'];
            $menuNode['has_child'] = true;

            unset($menuNode['children']);
        } else {
            $children = [];
            $menuNode['has_child'] = false;
        }

        $createdNode = MenuNode::create($menuNode);

        if ($children) {
            foreach ($children as $child) {
                $this->createMenuNode($index, $child, $locale, $menuId, $createdNode->id);
            }
        }
    }
}
