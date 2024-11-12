<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Faq\Repositories\Interfaces\FaqInterface;
use Botble\JobBoard\Models\Company;
use Botble\JobBoard\Models\Job;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use Botble\JobBoard\Repositories\Interfaces\CategoryInterface;
use Botble\JobBoard\Repositories\Interfaces\CompanyInterface;
use Botble\JobBoard\Repositories\Interfaces\JobExperienceInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\JobBoard\Repositories\Interfaces\JobSkillInterface;
use Botble\JobBoard\Repositories\Interfaces\JobTypeInterface;
use Botble\JobBoard\Repositories\Interfaces\PackageInterface;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\Team\Repositories\Interfaces\TeamInterface;
use Botble\Theme\Supports\ThemeSupport;
use Botble\Location\Models\City;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    if (is_plugin_active('job-board')) {
        add_shortcode('search-box', __('Search box'), __('The big search box'), function ($shortcode) {
            if ($shortcode->style === 'style-2') {
                $with = [
                    'slugable',
                    'metadata',
                ];

                $featureCompanies = app(CompanyInterface::class)
                    ->advancedGet([
                        'with' => $with,
                        'take' => (int)$shortcode->limit_company ?: 10,
                        'order_by' => ['created_at' => 'DESC'],
                        'condition' => [
                            'status' => BaseStatusEnum::PUBLISHED,
                            'is_featured' => 1,
                        ],
                    ]);

                return Theme::partial('shortcodes.search-box', compact('shortcode', 'featureCompanies'));
            }

            if ($shortcode->style === 'style-3') {
                $categories = app(CategoryInterface::class)
                    ->advancedGet([
                        'withCount' => ['jobs'],
                        'condition' => [
                          'status' => BaseStatusEnum::PUBLISHED,
                        ],
                        'with' => [
                            'slugable',
                            'metadata',
                        ],
                    ]);

                return Theme::partial('shortcodes.search-box', compact('shortcode', 'categories'));
            }

            return Theme::partial('shortcodes.search-box', compact('shortcode'));
        });

        shortcode()->setAdminConfig('search-box', function ($attributes) {
            return Theme::partial('shortcodes.search-box-admin-config', compact('attributes'));
        });

        add_shortcode('featured-job-categories', __('Featured job categories'), __('Featured job categories'), function ($shortcode) {
            $categories = app(CategoryInterface::class)
                ->getFeaturedCategories((int)$shortcode->limit_category ?: 10, [
                    'jobs' => function ($query) {
                        $query
                            ->where(JobBoardHelper::getJobDisplayQueryConditions())
                            ->addApplied()
                            ->orderBy('is_featured', 'DESC')
                            ->latest();
                    },
                    'metadata',
                ]);

            return Theme::partial('shortcodes.featured-job-categories', compact('shortcode', 'categories'));
        });

        shortcode()->setAdminConfig('featured-job-categories', function ($attributes) {
            return Theme::partial('shortcodes.featured-job-categories-admin-config', compact('attributes'));
        });

        shortcode()->setAdminConfig('job-categories', function ($attributes) {
            return Theme::partial('shortcodes.job-categories-admin-config', compact('attributes'));
        });

        add_shortcode('job-categories', __('Job categories'), __('Job categories'), function ($shortcode) {

            $categories = app(CategoryInterface::class)
                ->advancedGet(
                    [
                        'paginate' => [
                            'per_page' => (int)$shortcode->limit_category ?: 8,
                            'current_paged' => null,
                        ],
                        'condition' => [
                            'status' => BaseStatusEnum::PUBLISHED,
                        ],
                    ]
                );

            return Theme::partial('shortcodes.job-categories', compact('shortcode', 'categories'));
        });

        shortcode()->setAdminConfig('job-categories', function ($attributes) {
            return Theme::partial('shortcodes.job-categories-admin-config', compact('attributes'));
        });

        add_shortcode('apply-banner', __('Apply banner'), __('Apply banner show form apply'), function ($shortcode) {
            $subtitleText = '';

            if ($shortcode->highlight_sub_title_text) {
                $oldHighLightText = explode(',', $shortcode->highlight_sub_title_text);
                $newHighlightText = array_map(function ($value) {
                    return '<span class="color-brand-1">' . $value . '</span>';
                }, $oldHighLightText);

                $subtitleText = str_replace($oldHighLightText, $newHighlightText, $shortcode->subtitle);
            }

            return Theme::partial('shortcodes.apply-banner', compact('shortcode', 'subtitleText'));
        });

        shortcode()->setAdminConfig('apply-banner', function ($attributes) {
            return Theme::partial('shortcodes.apply-banner-admin-config', compact('attributes'));
        });

        add_shortcode('job-tabs', __('Job tabs'), __('Job tabs'), function ($shortcode) {
            $with = [
                'slugable',
                'jobTypes',
                'company',
                'company.slugable',
                'jobExperience',
            ];

            if (is_plugin_active('location')) {
                $with = array_merge($with, array_keys(Location::getSupported(Job::class)));
            }

            $featuredJobs = app(JobInterface::class)->getFeaturedJobs(10, $with);
            $recentJobs = app(JobInterface::class)->getRecentJobs(10, $with);
            $popularJobs = app(JobInterface::class)->getPopularJobs(10, $with);

            return Theme::partial('shortcodes.job-tabs', compact('shortcode', 'featuredJobs', 'recentJobs', 'popularJobs'));
        });

        shortcode()->setAdminConfig('job-tabs', function ($attributes) {
            return Theme::partial('shortcodes.job-tabs-admin-config', compact('attributes'));
        });

        add_shortcode('job-of-the-day', __('Job of the day'), __('Job of the day'), function ($shortcode) {
            $categoryIds = [];

            if ($shortcode->job_categories) {
                $categoryIds = explode(',', $shortcode->job_categories);
            }

            if (empty($categoryIds)) {
                return null;
            }

            $categories = app(CategoryInterface::class)
                ->advancedGet([
                    'with' => ['metadata'],
                    'condition' => [
                        'IN' => ['id', 'IN', $categoryIds],
                    ],
                ]);

            $with = [
                'slugable',
                'company',
                'jobTypes',
                'tags',
                'tags.slugable',
                'skills',
            ];

            if ((is_plugin_active('location'))) {
                $with = array_merge($with, [
                    'country',
                    'state',
                    'city',
                ]);
            }

            $jobs = app(JobInterface::class)
                ->getJobs(
                    [
                        'categories' => [$categories->value('id')],
                    ],
                    [
                        'with' => $with,
                        'take' => 8,
                    ]
                );

            return Theme::partial('shortcodes.job-of-the-day', compact('shortcode', 'categories', 'jobs'));
        });

        Assets::addStylesDirectly('vendor/core/core/base/libraries/tagify/tagify.css');

        shortcode()->setAdminConfig('job-of-the-day', function ($attributes) {
            $categories = app(CategoryInterface::class)->getCategories([]);

            return Html::script('vendor/core/core/base/libraries/tagify/tagify.js') .
                Html::script(Theme::asset()->url('js/tagify-select.js')) .
                Theme::partial('shortcodes.job-of-the-day-admin-config', compact('attributes', 'categories'));
        });

        add_shortcode('job-grid', __('Job grid banner'), __('Job grid banner'), function ($shortcode) {
            return Theme::partial('shortcodes.job-grid', compact('shortcode'));
        });

        add_shortcode('company-information', __('Company Information'), __('Company Information'), function ($shortcode) {
            return Theme::partial('shortcodes.company-information', compact('shortcode'));
        });

        shortcode()->setAdminConfig('company-information', function ($attributes) {
            return Theme::partial('shortcodes.company-information-admin-config', compact('attributes'));
        });

        add_shortcode('company-about', __('Company About'), __('Company About'), function ($shortcode) {
            return Theme::partial('shortcodes.company-about', compact('shortcode'));
        });

        shortcode()->setAdminConfig('company-about', function ($attributes) {
            return Theme::partial('shortcodes.company-about-admin-config', compact('attributes'));
        });

        add_shortcode('job-grid', __('Job grid banner'), __('Job grid banner'), function ($shortcode) {
            return Theme::partial('shortcodes.job-grid', compact('shortcode'));
        });

        shortcode()->setAdminConfig('job-grid', function ($attributes) {
            return Theme::partial('shortcodes.job-grid-admin-config', compact('attributes'));
        });

        if (is_plugin_active('location')) {
            add_shortcode('job-by-location', __('Job by location'), __('Job by location'), function ($shortcode) {
                $cityIds = array_filter(explode(',', $shortcode->city));

                City::resolveRelationUsing('companies', function ($model) {
                    return $model->hasMany(Company::class, 'city_id');
                });

                City::resolveRelationUsing('jobs', function ($model) {
                    return $model->hasMany(Job::class, 'city_id');
                });

                $cities = app(CityInterface::class)
                    ->advancedGet([
                        'with' => [
                            'jobs',
                            'companies',
                        ],
                        'withCount' => [
                            'jobs',
                            'companies',
                        ],
                        'condition' => [
                            'IN' => [
                                'id',
                                'IN',
                                $cityIds,
                            ],
                        ],
                        'take' => 6,
                    ]);

                $jobs = app(JobInterface::class)->getModel();

                return Theme::partial('shortcodes.job-by-location', compact('shortcode', 'cities', 'jobs'));
            });

            shortcode()->setAdminConfig('job-by-location', function ($attributes) {
                
                $cities = app(CityInterface::class)->filters(null);

                return Html::script('vendor/core/core/base/libraries/tagify/tagify.js') .
                    Html::script('themes/jobbox/js/tagify-select.js') .
                    Theme::partial('shortcodes.job-by-location-admin-config', compact('attributes', 'cities'));
            });
        }

        add_shortcode('news-and-blogs', __('News and blog'), __('News and blog'), function ($shortcode) {
            $posts = app(PostInterface::class)
                ->getFeatured(6, [
                    'slugable',
                    'tags',
                    'tags.slugable',
                    'metadata',
                    'author',
                ]);

            return Theme::partial('shortcodes.news-and-blogs', compact('shortcode', 'posts'));
        });

        shortcode()->setAdminConfig('news-and-blogs', function ($attributes) {
            return Theme::partial('shortcodes.news-and-blogs-admin-config', compact('attributes'));
        });

        add_shortcode('pricing-table', __('Pricing Table'), __('Pricing Table'), function ($shortcode) {
            $packages = app(PackageInterface::class)->advancedGet([
                'condition' => ['status' => BaseStatusEnum::PUBLISHED],
                'take' => (int)$shortcode->number_of_package ?: 6,
                'order_by' => ['created_at' => 'DESC'],
            ]);

            return Theme::partial('shortcodes.pricing-table', compact('shortcode', 'packages'));
        });

        shortcode()->setAdminConfig('pricing-table', function ($attributes) {
            return Theme::partial('shortcodes.pricing-table-admin-config', compact('attributes'));
        });

        shortcode()->setAdminConfig('job-grid', function ($attributes) {
            return Theme::partial('shortcodes.job-grid-admin-config', compact('attributes'));
        });

        add_shortcode('top-companies', __('Top companies table'), __('Top companies table'), function ($shortcode) {
            $with = ['slugable'];

            if (is_plugin_active('location')) {
                $with = array_merge($with, array_keys(Location::getSupported(Job::class)));
            }

            $companies = app(CompanyInterface::class)
                ->advancedGet([
                    'with' => $with,
                    'condition' => [
                        'is_featured' => 1,
                    ],
                    'withCount' => [
                        'reviews',
                        'jobs',
                    ],
                    'withAvg' => [
                        'reviews',
                        'star',
                    ],
                    'take' => 15,
                    'orderBy' => [
                        'created_at' => 'DESC',
                    ],
                ]);

            return Theme::partial('shortcodes.top-companies', compact('shortcode', 'companies'));
        });

        shortcode()->setAdminConfig('top-companies', function ($attributes) {
            return Theme::partial('shortcodes.top-companies-admin-config', compact('attributes'));
        });

        add_shortcode('popular-category', __('Popular category'), __('Popular category'), function ($shortcode) {
            $categories = app(CategoryInterface::class)
                ->getFeaturedCategories($shortcode->limit_category ?: 10);

            $categories->loadCount('activeJobs');

            return Theme::partial('shortcodes.popular-category', compact('shortcode', 'categories'));
        });

        shortcode()->setAdminConfig('popular-category', function ($attributes) {
            return Theme::partial('shortcodes.popular-category-admin-config', compact('attributes'));
        });

        add_shortcode('advertisement-banner', __('Advertisement banner'), __('Advertisement banner'), function ($shortcode) {
            return Theme::partial('shortcodes.advertisement-banner', compact('shortcode'));
        });

        shortcode()->setAdminConfig('advertisement-banner', function ($attributes) {
            return Theme::partial('shortcodes.advertisement-banner-admin-config', compact('attributes'));
        });

        add_shortcode('counter-section', __('Counter section'), __('Counter section'), function ($shortcode) {
            return Theme::partial('shortcodes.counter-section', compact('shortcode'));
        });

        shortcode()->setAdminConfig('counter-section', function ($attributes) {
            return Theme::partial('shortcodes.counter-section-admin-config', compact('attributes'));
        });

        add_shortcode('our-partners', __('Box Trust'), __('Box Trust'), function ($shortcode) {
            return Theme::partial('shortcodes.our-partners', compact('shortcode'));
        });

        shortcode()->setAdminConfig('our-partners', function ($attributes) {
            return Theme::partial('shortcodes.our-partners-admin-config', compact('attributes'));
        });

        add_shortcode('top-candidates', __('Top Candidates'), __('Top Candidates'), function ($shortcode) {
            $candidates = app(AccountInterface::class)
                ->getModel()
                ->with('slugable')
                ->withCount('reviews')
                ->withAvg('reviews', 'star')
                ->where('is_featured', 1)
                ->where('is_public_profile', 1)
                ->limit($shortcode->limit ?? 8)
                ->latest()
                ->get();

            return Theme::partial('shortcodes.top-candidates', compact('shortcode', 'candidates'));
        });

        shortcode()->setAdminConfig('top-candidates', function ($attributes) {
            return Theme::partial('shortcodes.top-candidates-admin-config', compact('attributes'));
        });

        add_shortcode('job-list', __('Job list'), __('Show job list'), function ($shortcode) {
            $requestQuery = JobBoardHelper::getJobFilters(request());

            if (! JobBoardHelper::jobFilterParamsValidated($requestQuery)) {
                $requestQuery = [];
            }

            $with = [
                'tags.slugable',
                'jobTypes',
                'slugable',
                'jobExperience',
                'company',
                'company.metadata',
                'company.slugable',
            ];

            if (is_plugin_active('location')) {
                $with = array_merge($with, array_keys(Location::getSupported(Job::class)));
            }

            $jobs = app(JobInterface::class)->getJobs(
                $requestQuery,
                [
                    'with' => $with,
                    'order_by' => [
                        'jb_jobs.created_at' => 'desc',
                        'jb_jobs.is_featured' => 'desc',
                    ],
                    'paginate' => [
                        'per_page' => $requestQuery['per_page'] ?: 10,
                        'current_paged' => $requestQuery['page'] ?: 1,
                    ],
                ],
            );

            $jobCategories = app(CategoryInterface::class)
                ->advancedGet(
                    [
                        'withCount' => [
                            'jobs' => function ($query) {
                                $query->where(JobBoardHelper::getJobDisplayQueryConditions());
                            },
                        ],
                        'condition' => [
                            'status' => BaseStatusEnum::PUBLISHED,
                        ],
                    ]
                );

            $jobTypes = app(JobTypeInterface::class)
                ->advancedGet([
                    'withCount' => [
                        'jobs' => function ($query) {
                            $query->where(JobBoardHelper::getJobDisplayQueryConditions());
                        },
                    ],
                    'condition' => [
                        'status' => BaseStatusEnum::PUBLISHED,
                    ],
                ]);

            $jobExperiences = app(JobExperienceInterface::class)
                ->advancedGet([
                    'withCount' => [
                        'jobs' => function ($query) {
                            $query->where(JobBoardHelper::getJobDisplayQueryConditions());
                        },
                    ],
                    'condition' => [
                        'status' => BaseStatusEnum::PUBLISHED,
                    ],
                ]);

            $jobSkills = app(JobSkillInterface::class)
                ->advancedGet([
                    'withCount' => [
                        'jobs' => function ($query) {
                            $query->where(JobBoardHelper::getJobDisplayQueryConditions());
                        },
                    ],
                    'condition' => [
                        'status' => BaseStatusEnum::PUBLISHED,
                    ],
                ]);

            return Theme::partial('shortcodes.job-list', compact(
                'shortcode',
                'jobs',
                'jobCategories',
                'jobTypes',
                'jobExperiences',
                'jobSkills'
            ));
        });

        shortcode()->setAdminConfig('job-list', function ($attributes) {
            return Theme::partial('shortcodes.job-list-admin-config', compact('attributes'));
        });

        add_shortcode('job-companies', __('Company list'), __('Company list'), function ($shortcode) {
            $requestQuery = JobBoardHelper::getCompanyFilterParams(request());
            $condition = [];

            if (! JobBoardHelper::companyFilterParamsValidated(request()->input())) {
                $requestQuery= [];
            }

            $sortBy = match ($requestQuery['sort_by'] ?? 'oldest') {
                'oldest' => [
                    'jb_companies.is_featured' => 'DESC',
                    'jb_companies.created_at' => 'DESC',
                ],
                default => [
                    'jb_companies.is_featured' => 'DESC',
                    'jb_companies.created_at' => 'ASC',
                ],
            };

            if ($requestQuery['keyword']) {
                $condition['like'] = ['jb_companies.name', 'like', $requestQuery['keyword'] . '%'];
            }

            $with = [
                'slugable',
                'metadata',
            ];

            if (is_plugin_active('location')) {
                $with = array_merge($with, array_keys(Location::getSupported(Company::class)));
            }

            $companies = app(CompanyInterface::class)
                ->advancedGet([
                    'withCount' => [
                        'jobs' => function ($query) {
                            $query->where(JobBoardHelper::getJobDisplayQueryConditions());
                        },
                        'reviews',
                    ],
                    'condition' => $condition,
                    'order_by' => $sortBy,
                    'with' => $with,
                    'withAvg' => ['reviews', 'star'],
                    'paginate' => [
                        'per_page' => (int)$requestQuery['per_page'] ?: 12,
                        'current_paged' => (int)$requestQuery['page'] ?: 1,
                    ],
                ]);

            return Theme::partial('shortcodes.job-companies', compact('shortcode', 'companies'));
        });

        shortcode()->setAdminConfig('job-companies', function ($attributes) {
            return Theme::partial('shortcodes.job-companies-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('contact')) {
        add_shortcode('contact-form', __('Contact Form'), __('Contact Form'), function ($shortcode) {
            return Theme::partial('shortcodes.contact-form', compact('shortcode'));
        });

        shortcode()->setAdminConfig('contact-form', function ($attributes) {
            return Theme::partial('shortcodes.contact-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('team')) {
        add_shortcode('team', __('Team'), __('Team'), function ($shortcode) {
            $teams = app(TeamInterface::class)->advancedGet([
                'condition' => ['status' => BaseStatusEnum::PUBLISHED],
                'take' => (int)$shortcode->number_of_people ?: 6,
                'order_by' => ['created_at' => 'DESC'],
            ]);

            return Theme::partial('shortcodes.team', compact('shortcode', 'teams'));
        });

        shortcode()->setAdminConfig('team', function ($attributes) {
            return Theme::partial('shortcodes.team-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('testimonial')) {
        add_shortcode('testimonials', __('Testimonials'), __('Testimonials'), function ($shortcode) {
            return Theme::partial('shortcodes.testimonials', compact('shortcode'));
        });

        shortcode()->setAdminConfig('testimonials', function ($attributes) {
            return Theme::partial('shortcodes.testimonials-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('faq')) {
        add_shortcode('faq', __('FAQ'), __('FAQ'), function ($shortcode) {
            $faqs = app(FaqInterface::class)->advancedGet([
                'condition' => ['status' => BaseStatusEnum::PUBLISHED],
                'take' => (int)$shortcode->number_of_faq ?: 6,
                'order_by' => ['created_at' => 'DESC'],
            ]);

            return Theme::partial('shortcodes.faq', compact('shortcode', 'faqs'));
        });

        shortcode()->setAdminConfig('faq', function ($attributes) {
            return Theme::partial('shortcodes.faq-admin-config', compact('attributes'));
        });
    }

    add_shortcode('gallery', __('Gallery'), __('Gallery'), function ($shortcode) {
        return Theme::partial('shortcodes.gallery', compact('shortcode'));
    });

    shortcode()->setAdminConfig('gallery', function ($attributes) {
        return Theme::partial('shortcodes.gallery-admin-config', compact('attributes'));
    });

    add_shortcode('job-search-banner', __('Job search banner'), __('Job search banner'), function ($shortcode) {
        return Theme::partial('shortcodes.job-search-banner', compact('shortcode'));
    });

    shortcode()->setAdminConfig('job-search-banner', function ($attributes) {
        return Theme::partial('shortcodes.job-search-banner-admin-config', compact('attributes'));
    });

    add_shortcode('how-it-works', __('How It Works'), __('How It Works'), function ($shortcode) {
        return Theme::partial('shortcodes.how-it-works', compact('shortcode'));
    });

    shortcode()->setAdminConfig('how-it-works', function ($attributes) {
        return Theme::partial('shortcodes.how-it-works-admin-config', compact('attributes'));
    });

    add_shortcode('job-candidates', __('Job Candidates'), __('Job Candidates'), function ($shortcode) {
        $candidates = JobBoardHelper::filterCandidates(request()->input());

        return Theme::partial('shortcodes.job-candidates', compact('shortcode', 'candidates'));
    });

    shortcode()->setAdminConfig('job-candidates', function ($attributes) {
        return Theme::partial('shortcodes.job-candidates-admin-config', compact('attributes'));
    });

    if (is_plugin_active('testimonial')) {
        add_shortcode('testimonials', __('Testimonials'), __('Testimonials'), function ($shortcode) {
            return Theme::partial('shortcodes.testimonials', compact('shortcode'));
        });

        shortcode()->setAdminConfig('testimonials', function ($attributes) {
            return Theme::partial('shortcodes.testimonials-admin-config', compact('attributes'));
        });
    }
});
