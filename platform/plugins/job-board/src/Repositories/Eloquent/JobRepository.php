<?php

namespace Botble\JobBoard\Repositories\Eloquent;

use Botble\JobBoard\Models\Job;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use JobBoardHelper;
use Location;

class JobRepository extends RepositoriesAbstract implements JobInterface
{
    public function getJobs($filters = [], $params = [])
    {
        if (! JobBoardHelper::jobFilterParamsValidated($filters)) {
            $filters = [];
        }

        $filters = array_merge([
            'keyword' => null,
            'city_id' => null,
            'city' => null,
            'location' => null,
            'categories' => [],
            'tags' => [],
            'types' => [],
            'experiences' => [],
            'skills' => [],
            'offered_salary_from' => null,
            'offered_salary_to' => null,
            'date_posted' => null,
        ], $filters);

        $with = [
            'slugable',
            'tags',
            'jobTypes',
            'jobExperience',
            'company',
            'company.slugable',
        ];

        if (is_plugin_active('location')) {
            $with = array_merge($with, array_keys(Location::getSupported(Job::class)));
        }

        $params = array_merge([
            'condition' => JobBoardHelper::getJobDisplayQueryConditions(),
            'order_by' => [
                'jb_jobs.created_at' => 'DESC',
                'jb_jobs.is_featured' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => 20,
                'current_paged' => 1,
            ],
            'select' => ['jb_jobs.*'],
            'with' => $with,
            'withCount' => ['applicants'],
        ], $params);

        $this->model = $this->originalModel;

        $this->model = $this->model->select($params['select'])->notExpired();

        $keyword = $filters['keyword'];

        if ($keyword) {
            $this->model = $this->model
                ->where(function ($query) use ($keyword) {
                    $query
                        ->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhereHas('company', function ($query) use ($keyword) {
                            $query
                                ->where('jb_jobs.hide_company', false)
                                ->where('name', 'LIKE', '%' . $keyword . '%');
                        })
                        ->orWhereHas('tags', function ($query) use ($keyword) {
                            $query->where(function ($subQuery) use ($keyword) {
                                $subQuery->addSearch('name', $keyword, false);
                            });
                        })
                        ->orWhereHas('skills', function ($query) use ($keyword) {
                            $query->where(function ($subQuery) use ($keyword) {
                                $subQuery->addSearch('name', $keyword, false);
                            });
                        });
                });
        }

        if (is_plugin_active('location') && ((int)$filters['city_id'] || $filters['location'])) {
            $this->model = Location::filter($this->model, (int)$filters['city_id'], $filters['location']);
        }

        // Filter jobs by categories
        $filters['categories'] = array_map('intval', array_filter($filters['categories']));
        if ($filters['categories']) {
            $this->model = $this->model->whereHas('categories', function (Builder $query) use ($filters) {
                $query->whereIn('jb_jobs_categories.category_id', $filters['categories']);
            });
        }

        // Filter jobs by tag
        $filters['tags'] = array_map('intval', array_filter($filters['tags']));
        if ($filters['tags']) {
            $this->model = $this->model->whereHas('tags', function (Builder $query) use ($filters) {
                $query->whereIn('jb_jobs_tags.tag_id', $filters['tags']);
            });
        }
        // Filter job by types
        $filters['types'] = array_map('intval', array_filter($filters['types']));
        if ($filters['types']) {
            $this->model = $this->model->whereHas('jobTypes', function ($query) use ($filters) {
                return $query->whereIn('jb_jobs_types.job_type_id', $filters['types']);
            });
        }

        // Filter job by experiences
        $filters['experiences'] = array_map('intval', array_filter($filters['experiences']));
        if ($filters['experiences']) {
            $this->model = $this->model->whereIn('jb_jobs.job_experience_id', $filters['experiences']);
        }

        // Filter job by offered salary
        if ($filters['offered_salary_from'] && $filters['offered_salary_from'] > 0) {
            $this->model = $this->model->where('jb_jobs.salary_from', '>=', $filters['offered_salary_from']);
        }
        if ($filters['offered_salary_to'] && $filters['offered_salary_to'] > 0) {
            $this->model = $this->model->where('jb_jobs.salary_to', '<=', $filters['offered_salary_to']);
        }

        // Filter job by skills
        $filters['skills'] = array_map('intval', array_filter($filters['skills']));
        if ($filters['skills']) {
            $this->model = $this->model->whereHas('skills', function ($query) use ($filters) {
                return $query->whereIn('jb_jobs_skills.job_skill_id', $filters['skills']);
            });
        }

        if ($filters['date_posted'] && $date = Arr::get(JobBoardHelper::postedDateRanges(), $filters['date_posted'])) {
            if ($start = Arr::get($date, 'start')) {
                $this->model = $this->model->whereDate('jb_jobs.created_at', '<=', $start);
            }
            if ($end = Arr::get($date, 'end')) {
                $this->model = $this->model->whereDate('jb_jobs.created_at', '>=', $end);
            }
        }

        $this->model = $this->model->addSavedApplied();
        $params['select'] = []; // Reset select to avoid duplicate columns

        return $this->advancedGet($params);
    }

    public function getFeaturedJobs(int $limit = 10, array $with = [])
    {
        $params = [
            'condition' => [
                    'jb_jobs.is_featured' => true,
                ] + JobBoardHelper::getJobDisplayQueryConditions(),
            'order_by' => [
                'jb_jobs.created_at' => 'DESC',
            ],
            'take' => $limit,
        ];

        if ($with) {
            $params['with'] = $with;
        }

        return $this->getJobs([], $params);
    }

    public function getRecentJobs(int $limit = 10, array $with = [])
    {
        $params = [
            'order_by' => [
                'jb_jobs.created_at' => 'DESC',
            ],
            'take' => $limit,
        ];
        if ($with) {
            $params['with'] = $with;
        }

        return $this->getJobs([], $params);
    }

    public function getPopularJobs(int $limit = 10, array $with = [])
    {
        $params = [
            'order_by' => [
                'jb_jobs.views' => 'DESC',
                'jb_jobs.created_at' => 'DESC',
            ],
            'take' => $limit,
        ];
        if ($with) {
            $params['with'] = $with;
        }

        return $this->getJobs([], $params);
    }

    public function countActiveJobs()
    {
        $data = $this->model
            ->notExpired()
            ->where(JobBoardHelper::getJobDisplayQueryConditions());

        return $this->applyBeforeExecuteQuery($data)->count('jb_jobs.id');
    }
}
