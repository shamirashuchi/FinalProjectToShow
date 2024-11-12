<?php

namespace Theme\Jobbox\Http\Controllers;

use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Models\Job;
use Botble\JobBoard\Repositories\Interfaces\CategoryInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\Location\Http\Resources\CityResource;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\Testimonial\Repositories\Interfaces\TestimonialInterface;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Theme\Jobbox\Http\Resources\CategoryResource;
use Theme\Jobbox\Http\Resources\TestimonialResource;
use JobBoardHelper;
use Theme;
use Location;

class JobboxController extends PublicController
{
    public function ajaxGetCities(Request $request, CityInterface $cityRepository, BaseHttpResponse $response)
    {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $keyword = BaseHelper::stringify($request->query('k'));

        $cities = $cityRepository->filters($keyword, 10, ['state']);

        return $response->setData(CityResource::collection($cities));
    }

    public function ajaxGetTestimonials(
        Request $request,
        BaseHttpResponse $response,
        TestimonialInterface $testimonialRepository
    ) {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $testimonials = $testimonialRepository->advancedGet([
            'condition' => [
                'status' => BaseStatusEnum::PUBLISHED,
            ],
        ]);

        return $response->setData(TestimonialResource::collection($testimonials));
    }

    public function ajaxGetJobCategories(
        Request $request,
        BaseHttpResponse $response,
        CategoryInterface $categoryRepository
    ) {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $keyword = BaseHelper::stringify($request->query('k'));

        $condition = [
            'with' => ['slugable'],
            'paginate' => [
                'per_page' => 10,
                'current_paged' => 1,
            ],
        ];

        if ($keyword) {
            $condition['condition'] = ['keyword' => ['name', 'like', '%' . $keyword . '%']];
        }

        $categories = $categoryRepository->advancedGet($condition);

        return $response->setData(CategoryResource::collection($categories));
    }

    public function ajaxGetJobByCategories(
        $categoryId,
        Request $request,
        BaseHttpResponse $response,
        JobInterface $jobRepository
    ) {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $validator = Validator::make($request->input(), [
            'style' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $response->setNextUrl(route('public.index'));
        }

        $with = [
            'company',
            'slugable',
            'metadata',
        ];

        if (is_plugin_active('location')) {
            $with = array_merge($with, array_keys(Location::getSupported(Job::class)));
        }

        $view = Theme::getThemeNamespace('views.job-board.partials.job-of-the-day-items');

        $style = BaseHelper::stringify($request->input('style')) ?: 'style-1';

        $jobs = $jobRepository
            ->getJobs(
                array_merge(JobBoardHelper::getJobFilters($request), [
                    'categories' => [$categoryId],
                ]),
                [
                    'paginate' => [
                        'per_page' => 8,
                        'current_paged' => (int)$request->input('page'),
                    ],
                    'with' => $with,
                ]
            );

        return $response
            ->setData(view($view, compact('jobs', 'style'))->render());
    }
}
