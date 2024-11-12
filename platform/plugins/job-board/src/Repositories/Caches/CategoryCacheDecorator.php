<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\CategoryInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class CategoryCacheDecorator extends CacheAbstractDecorator implements CategoryInterface
{
    public function getFeaturedCategories(int $limit = 8, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getCategories(array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
