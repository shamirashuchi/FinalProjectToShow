<?php

namespace Botble\JobBoard\Repositories\Interfaces;

use Botble\JobBoard\Models\Job;
use Botble\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface JobInterface extends RepositoryInterface
{
    /**
     * @param array $filters
     * @param array $params
     * @return LengthAwarePaginator|Job
     */
    public function getJobs($filters = [], $params = []);

    /**
     * @param int $limit
     * @param array $with
     * @return mixed
     */
    public function getFeaturedJobs(int $limit = 10, array $with = []);

    /**
     * @param int $limit
     * @param array $with
     * @return mixed
     */
    public function getRecentJobs(int $limit = 10, array $with = []);

    /**
     * @param int $limit
     * @param array $with
     * @return mixed
     */
    public function getPopularJobs(int $limit = 10, array $with = []);

    /**
     * @return int
     */
    public function countActiveJobs();
}
