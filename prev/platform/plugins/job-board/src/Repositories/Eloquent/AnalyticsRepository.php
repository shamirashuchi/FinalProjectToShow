<?php

namespace Botble\JobBoard\Repositories\Eloquent;

use Botble\JobBoard\Repositories\Interfaces\AnalyticsInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class AnalyticsRepository extends RepositoriesAbstract implements AnalyticsInterface
{
    public function getReferrers(int $jobId, int $limit = 10)
    {
        $data = $this->model
            ->where('job_id', $jobId)
            ->selectRaw('referer, COUNT(*) as total')
            ->groupBy('referer')
            ->orderBy('total', 'DESC')
            ->limit($limit ?: 10);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * Get the Views a URL had
     *
     * @param int $jobId
     * @return int
     */
    public function getViews(int $jobId): int
    {
        return $this->model->where('job_id', $jobId)->count();
    }

    public function getTodayViews(int $jobId): int
    {
        $data = $this->model
            ->where('job_id', $jobId)
            ->whereDate('created_at', now());

        return $this->applyBeforeExecuteQuery($data)->count();
    }

    public function getCountriesViews(int $jobId)
    {
        $data = $this->model
            ->where('job_id', $jobId)
            ->selectRaw('country_full, COUNT(*) as total')
            ->groupBy('country_full')
            ->orderBy('total', 'DESC')
            ->limit(10);

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
