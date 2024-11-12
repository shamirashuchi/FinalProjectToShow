<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\CompanyInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class CompanyCacheDecorator extends CacheAbstractDecorator implements CompanyInterface
{
    public function getSearch($query, $limit = 10, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
