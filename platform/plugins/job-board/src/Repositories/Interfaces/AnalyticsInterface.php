<?php

namespace Botble\JobBoard\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface AnalyticsInterface extends RepositoryInterface
{
    /**
     * Load the short URL referrers' list
     *
     * @param int $jobId
     * @param int $limit
     * @return Builder[]|Collection
     */
    public function getReferrers(int $jobId, int $limit = 10);

    /**
     * Get the Views a URL had
     *
     * @param int $jobId
     * @return int
     */
    public function getViews(int $jobId);

    /**
     * Load the Views made today to the URL
     *
     * @param int $jobId
     * @return int
     */
    public function getTodayViews(int $jobId);

    /**
     * Get the list of the URL's visitors countries
     *
     * @param int $jobId
     * @return Builder[]|Collection
     */
    public function getCountriesViews(int $jobId);
}
