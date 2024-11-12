<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\AnalyticsInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class AnalyticsCacheDecorator extends CacheAbstractDecorator implements AnalyticsInterface
{
    public function getReferrers(int $jobId, int $limit = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getViews(int $jobId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getTodayViews(int $jobId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getCountriesViews(int $jobId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
