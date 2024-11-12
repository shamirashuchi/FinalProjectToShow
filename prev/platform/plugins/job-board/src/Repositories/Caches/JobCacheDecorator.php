<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class JobCacheDecorator extends CacheAbstractDecorator implements JobInterface
{
    public function getJobs($filters = [], $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getFeaturedJobs(int $limit = 10, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getRecentJobs(int $limit = 10, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getPopularJobs(int $limit = 10, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function countActiveJobs()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
